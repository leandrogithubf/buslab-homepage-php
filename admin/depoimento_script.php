<?php 
    // Versao do modulo: 3.00.010416

if(!isset($_REQUEST['ajax']) || empty($_REQUEST['ajax'])){
   require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_DEPOIMENTO") || define("CADASTRO_DEPOIMENTO","cadastroDepoimento");
defined("EDIT_DEPOIMENTO") || define("EDIT_DEPOIMENTO","editDepoimento");
defined("DELETA_DEPOIMENTO") || define("DELETA_DEPOIMENTO","deletaDepoimento");

defined("INVERTE_STATUS") || define("INVERTE_STATUS", "inverteStatus");
defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA", "alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO", "alteraOrdemBaixo");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");

switch ($opx) {

   case CADASTRO_DEPOIMENTO:
      include_once 'depoimento_class.php';
      include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

      $dados = $_REQUEST;
      $imagem = $_FILES;

      if(empty($dados['status'])){
         $dados['status'] = 2;
      }
      if(empty($dados['imagem'])){
         $dados['imagem'] = "";
      }

      if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
         $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
         $nomeimagem = fileImage("depoimento", "", '', $imagem['imagemCadastrar'], 110, 110, 'cropped', $coordenadas);
         fileImage("depoimento", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');
         $dados['imagem'] = $nomeimagem;
      }

      // print_r($dados);die;
      
      $idDepoimento = cadastroDepoimento($dados);

      if (is_int($idDepoimento)) {
         if($dados['ajax']){
            echo '{"status":true}';
         }else{
            //salva log
            include_once 'log_class.php';
            $log['idusuario'] = $_SESSION['sgc_idusuario'];
            $log['modulo'] = 'depoimento';
            $log['descricao'] = 'Cadastrou depoimento ID('.$idDepoimento.') nome ('.$dados['nome'].') depoimento ('.$dados['depoimento'].') ordem ('.$dados['ordem'].') status ('.$dados['status'].') imagem ('.$dados['imagem'].')';
            $log['request'] = $_REQUEST;
            novoLog($log);
            header('Location: index.php?mod=depoimento&acao=listarDepoimento&mensagemalerta='.urlencode('Depoimento criado com sucesso!'));
         }
      } else {
         header('Location: index.php?mod=depoimento&acao=listarDepoimento&mensagemalerta='.urlencode('ERRO ao criar novo Depoimento!'));
      }

   break;

   case EDIT_DEPOIMENTO:
      include_once 'depoimento_class.php';
      include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

      $dados = $_REQUEST;
      $imagem = $_FILES;
      $antigo = buscaDepoimento(array('iddepoimento'=>$dados['iddepoimento']));
      $antigo = $antigo[0];

      if (isset($_FILES['imagemCadastrar']) && $_FILES['imagemCadastrar']['error'] == 0) {
         $coordenadas = getDataImageCrop($imagem, $_POST['coordenadas']);
         $nomeimagem = fileImage("depoimento", "", '', $imagem['imagemCadastrar'], 110, 110, 'cropped', $coordenadas);
         fileImage("depoimento", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');
         apagarImagemDepoimento($antigo['imagem']);  
         $dados['imagem'] = $nomeimagem;
      }

      $idDepoimento = editDepoimento($dados);

      if ($idDepoimento != FALSE) {
         //salva log
         include_once 'log_class.php';
         $log['idusuario'] = $_SESSION['sgc_idusuario'];
         $log['modulo'] = 'depoimento';
         $log['descricao'] = 'Editou depoimento ID('.$idDepoimento.') DE  nome ('.$antigo['nome'].') depoimento ('.$antigo['depoimento'].') ordem ('.$antigo['ordem'].') status ('.$antigo['status'].') imagem ('.$antigo['imagem'].') PARA  nome ('.$dados['nome'].') depoimento ('.$dados['depoimento'].') ordem ('.$dados['ordem'].') status ('.$dados['status'].') imagem ('.$dados['imagem'].')';
         $log['request'] = $_REQUEST;
         novoLog($log);
         header('Location: index.php?mod=depoimento&acao=listarDepoimento&mensagemalerta='.urlencode('Depoimento salvo com sucesso!'));
      } else {
         header('Location: index.php?mod=depoimento&acao=listarDepoimento&mensagemalerta='.urlencode('ERRO ao salvar Depoimento!'));
      }

   break;

   case DELETA_DEPOIMENTO:
      include_once 'depoimento_class.php';
      include_once 'usuario_class.php';
      if (!verificaPermissaoAcesso('depoimento_deletar', $_SESSION['sgc_idusuario'])){
         header('Location: index.php?mod=depoimento&acao=listarDepoimento&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
         exit;
      } else {
         $dados = $_REQUEST;
         $antigo = buscaDepoimento(array('iddepoimento'=>$dados['idu']));

         if (deletaDepoimento($dados['idu']) == 1) {
            apagarImagemDepoimento($antigo[0]['imagem']);  
            //salva log
            include_once 'log_class.php';
            $log['idusuario'] = $_SESSION['sgc_idusuario'];
            $log['modulo'] = 'depoimento';
            $log['descricao'] = 'Deletou depoimento ID('.$dados['idu'].') ';
            $log['request'] = $_REQUEST;
            novoLog($log);
            header('Location: index.php?mod=depoimento&acao=listarDepoimento&mensagemalerta='.urlencode('Depoimento deletado com sucesso!'));
         } else {
            header('Location: index.php?mod=depoimento&acao=listarDepoimento&mensagemalerta='.urlencode('ERRO ao deletar Depoimento!'));
         }
      }

   break;

   case ALTERA_ORDEM_CIMA:
      include_once("depoimento_class.php");

      $dados = $_REQUEST;
      $resultado['status'] = 'sucesso';

      try {

         $depoimento = buscaDepoimento(array('iddepoimento' => $dados['iddepoimento']));
         $depoimento = $depoimento[0];

         $ordem = $depoimento['ordem'] - 1;

         $depoimentoAux = buscaDepoimento(array('order' => $ordem));


         if (!empty($depoimentoAux)) {

            $dadosUpdate = array();
            $dadosUpdate['iddepoimento'] = $dados['iddepoimento'];
            $dadosUpdate['ordem'] = $ordem;
            editOrdemDepoimento($dadosUpdate);

            $dadosUpdate2 = array();
            $dadosUpdate2['iddepoimento'] = $depoimentoAux[0]['iddepoimento'];
            $dadosUpdate2['ordem'] = intval($depoimento['ordem']);
            editOrdemDepoimento($dadosUpdate2);
         }

         print json_encode($resultado);
      } catch (Exception $e) {
         $resultado['status'] = 'falha';
         print json_encode($resultado);
      }
   break;

   case ALTERA_ORDEM_BAIXO:
      include_once("depoimento_class.php");

      $dados = $_REQUEST;
      $resultado['status'] = 'sucesso';

      try {
         $depoimento = buscaDepoimento(array('iddepoimento' => $dados['iddepoimento']));
         $depoimento = $depoimento[0];

         $ordem = $depoimento['ordem'] + 1;

         $depoimentoAux = buscaDepoimento(array('order' => $ordem));


         if (!empty($depoimentoAux)) {

            $dadosUpdate = array();
            $dadosUpdate['iddepoimento'] = $dados['iddepoimento'];
            $dadosUpdate['ordem'] = $ordem;
            editOrdemDepoimento($dadosUpdate);

            $dadosUpdate2 = array();
            $dadosUpdate2['iddepoimento'] = $depoimentoAux[0]['iddepoimento'];
            $dadosUpdate2['ordem'] = intval($depoimento['ordem']);
            editOrdemDepoimento($dadosUpdate2);
         }

         print json_encode($resultado);
      } catch (Exception $e) {
         $resultado['status'] = 'falha';
         print json_encode($resultado);
      }
   break;

   case INVERTE_STATUS:
      include_once("depoimento_class.php");
      include_once("includes/functions.php");
      $dados = $_REQUEST;
      // inverteStatus($dados);
      $resultado['status'] = 'sucesso';

      $tabela = 'depoimento';
      $id = 'iddepoimento';

      try {
         $depoimento = buscaDepoimento(array('iddepoimento' => $dados['iddepoimento']));
         $depoimento = $depoimento[0];

         // print_r($depoimento);
         if($depoimento['status'] == 1){
            $status = 0;
         }
         else{
            $status = 1;
         }

         $dadosUpdate = array();
         $dadosUpdate['iddepoimento'] = $dados['iddepoimento'];
         $dadosUpdate['status'] = $status;
         inverteStatus($dadosUpdate,$tabela,$id);

         print json_encode($resultado);
      } catch (Exception $e) {
         $resultado['status'] = 'falha';
         print json_encode($resultado);
      }
   break;

   case SALVA_IMAGEM:

      include_once('depoimento_class.php');
      include_once 'includes/fileImage.php';

      $dados = $_POST;
        $iddepoimento = $dados['iddepoimento'];
        $imgAntigo = $dados['imagem_antigo']; 
        $tipo_depoimento = $dados['tipo_depoimento'];
        
        $imagem = $_FILES;
        $antigo = array();
        if(!empty($iddepoimento) &&  $iddepoimento > 0){
            $antigo = buscaDepoimento(array('iddepoimento'=>$iddepoimento));
         $antigo = $antigo[0];
        }    
        
        //dados para o crop
        if($tipo_depoimento == 'logo'){
            //depoimento full
            $width = 151;
            $height = 35;
            // $nomeimagem = fileImage("depoimento", "", "", $imagem['imagem'], $width, $height, 'resize'); 
         // $nomeimagem = fileImage("depoimento", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
        else if($tipo_depoimento == 'imagem'){
            //depoimento mobile
            $width = 110;
            $height = 110;
         //    $nomeimage = fileImage("depoimento", "", "", $imagem['imagem'], $width, $height, 'resize'); 
         // $nomeimagem = fileImage("depoimento", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
         
        //imagem 
        // $nomeimagem = fileImage("depoimento", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        $nomeimagem = fileImage("depoimento", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        // $nomeimagem = fileImage("depoimento", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        
        $caminho = 'files/depoimento/'.$nomeimagem;

        if(file_exists($caminho)){
         //apaga os arquivos anteriores que foram salvos
         if(!empty($imgAntigo)){
            $apgImage = apagarImagemDepoimento($imgAntigo); 
         }
          
         if(is_numeric($iddepoimento) && $iddepoimento > 0){
            //edita o nome do depoimento, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
            $depoimento = $antigo; 
            $depoimento[$tipo_depoimento] = $nomeimagem;
            $edita = editDepoimento($depoimento);             
         } 

            echo '{"status":true, "caminho":"'.$caminho.'", "tipo":"'.$tipo_depoimento.'", "iddepoimento":"'.$iddepoimento.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "tipo":"'.$tipo_depoimento.'", "iddepoimento":"'.$iddepoimento.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
        }

   break;

   default:
      if (!headers_sent() && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
         header('Location: index.php?mod=home&mensagemalerta='.urlencode('Nenhuma acao definida...'));
      } else {
         trigger_error('Erro...', E_USER_ERROR);
         exit;
      }

}
