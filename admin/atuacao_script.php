<?php 
	 // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_ATUACAO") || define("CADASTRO_ATUACAO","cadastroAtuacao");
defined("EDIT_ATUACAO") || define("EDIT_ATUACAO","editAtuacao");
defined("DELETA_ATUACAO") || define("DELETA_ATUACAO","deletaAtuacao");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA","alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO","alteraOrdemBaixo");
defined("BUSCA_ATUACAO") || define("BUSCA_ATUACAO","buscaAtuacao");

switch ($opx) {

   case BUSCA_ATUACAO:
      include_once 'atuacao_class.php';
      $dados = $_POST;
      $dados['ordem'] = "nome asc";
      $categorias = buscaAtuacao($dados);
      $retorno['dados'] = $categorias;

      print json_encode($retorno);
   break;

	case CADASTRO_ATUACAO:
		include_once 'atuacao_class.php';

		$dados = $_REQUEST;
		$idAtuacao = cadastroAtuacao($dados);

		if (is_int($idAtuacao)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'atuacao';
			$log['descricao'] = 'Cadastrou atuacao ID('.$idAtuacao.') nome ('.$dados['nome'].') logo ('.$dados['logo'].') idioma ('.$dados['idioma'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') servicos ('.$dados['servicos'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=atuacao&acao=listarAtuacao&mensagemalerta='.urlencode('Atuação criado com sucesso!'));
		} else {
			header('Location: index.php?mod=atuacao&acao=listarAtuacao&mensagemalerta='.urlencode('ERRO ao criar novo Atuação!'));
		}

	break;

	case EDIT_ATUACAO:
		include_once 'atuacao_class.php';

		$dados = $_REQUEST;
		$antigo = buscaAtuacao(array('idatuacao'=>$dados['idatuacao']));
		$antigo = $antigo[0];

		$idAtuacao = editAtuacao($dados);

		if ($idAtuacao != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'atuacao';
			$log['descricao'] = 'Editou atuacao ID('.$idAtuacao.') DE  nome ('.$antigo['nome'].') logo ('.$antigo['logo'].') idioma ('.$antigo['idioma'].') texto ('.$antigo['texto'].') imagem ('.$antigo['imagem'].') servicos ('.$antigo['servicos'].') PARA  nome ('.$dados['nome'].') logo ('.$dados['logo'].') idioma ('.$dados['idioma'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') servicos ('.$dados['servicos'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=atuacao&acao=listarAtuacao&mensagemalerta='.urlencode('Atuação salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=atuacao&acao=listarAtuacao&mensagemalerta='.urlencode('ERRO ao salvar Atuação!'));
		}

	break;

	case DELETA_ATUACAO:
		include_once 'atuacao_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('atuacao_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=atuacao&acao=listarAtuacao&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaAtuacao(array('idatuacao'=>$dados['idu']));

			if (deletaAtuacao($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'atuacao';
				$log['descricao'] = 'Deletou atuacao ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=atuacao&acao=listarAtuacao&mensagemalerta='.urlencode('Atuação deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=atuacao&acao=listarAtuacao&mensagemalerta='.urlencode('ERRO ao deletar Atuação!'));
			}
		}

	break;

	case SALVA_IMAGEM:

        include_once('atuacao_class.php');
		include_once 'includes/fileImage.php';

		$dados = $_POST;
        $idatuacao = $dados['idatuacao'];
        $imgAntigo = $dados['imagem_antigo']; 
        $tipo_atuacao = $dados['tipo_atuacao'];
        
        $imagem = $_FILES;
        $antigo = array();
        if(!empty($idatuacao) &&  $idatuacao > 0){
            $antigo = buscaAtuacao(array('idatuacao'=>$idatuacao));
			$antigo = $antigo[0];
        }    
        
        //dados para o crop
        if($tipo_atuacao == 'logo'){
            //atuacao full
            $width = 209;
            $height = 209;
            // $nomeimagem = fileImage("atuacao", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("atuacao", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
        else if($tipo_atuacao == 'imagem'){
            //atuacao mobile
            $width = 209;
            $height = 209;
         //    $nomeimage = fileImage("atuacao", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("atuacao", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
       	
        //imagem 
        $nomeimagem = fileImage("atuacao", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        // $nomeimagem = fileImage("atuacao", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
	     
        $caminho = 'files/atuacao/'.$nomeimagem;

        if(file_exists($caminho)){
        	//apaga os arquivos anteriores que foram salvos
        	if(!empty($imgAntigo)){
        		$apgImage = apagarImagemAtuacao($imgAntigo); 
        	}
		 	 
			if(is_numeric($idatuacao) && $idatuacao > 0){
				//edita o nome do atuacao, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
				$atuacao = $antigo; 
				$atuacao[$tipo_atuacao] = $nomeimagem;
				$edita = editAtuacao($atuacao);				 
			} 

            echo '{"status":true, "caminho":"'.$caminho.'", "tipo":"'.$tipo_atuacao.'", "idatuacao":"'.$idatuacao.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "tipo":"'.$tipo_atuacao.'", "idatuacao":"'.$idatuacao.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
        }

    break;

    case ALTERA_ORDEM_CIMA:
      include_once("atuacao_class.php");

      $dados = $_REQUEST; 
      $resultado['status'] = 'sucesso';

      try {

         $atuacao = buscaAtuacao(array('idatuacao'=>$dados['idatuacao']));
         $atuacao = $atuacao[0];
         $ordemAux = 0;
         $ordem = $atuacao['ordem'];

         while($ordemAux == 0)
         {
             $ordem = $ordem - 1;
             $atuacaoAux = buscaAtuacao(array('order'=>$ordem));

             if(!empty($atuacaoAux)){
               $atuacaoAux = $atuacaoAux[0];
               $ordemAux = $atuacaoAux['ordem'];
             }
         }

         if(!empty($atuacaoAux)){

            $atuacaoAux['ordem'] = $atuacao['ordem'];
            $atuacao['ordem'] = $ordemAux;

            editAtuacao($atuacao);
            editAtuacao($atuacaoAux);
          }

         print json_encode($resultado);

      } catch (Exception $e) {
         $resultado['status'] = 'falha';
         print json_encode($resultado);
      }
   break;

   case ALTERA_ORDEM_BAIXO:
      include_once("atuacao_class.php");

      $dados = $_REQUEST; 
      $resultado['status'] = 'sucesso';

      try {
         $atuacao = buscaAtuacao(array('idatuacao'=>$dados['idatuacao']));
         $atuacao = $atuacao[0];
         $ordemAux = 0;
         $ordem = $atuacao['ordem'];

         while($ordemAux == 0)
         {
             $ordem = $ordem + 1;
             $atuacaoAux = buscaAtuacao(array('order'=>$ordem));

             if(!empty($atuacaoAux)){
               $atuacaoAux = $atuacaoAux[0];
               $ordemAux = $atuacaoAux['ordem'];
             }

         }

         if(!empty($atuacaoAux)){
            $atuacaoAux['ordem'] = $atuacao['ordem'];
            $atuacao['ordem'] = $ordemAux;

            editAtuacao($atuacao);
            editAtuacao($atuacaoAux);
          }

         print json_encode($resultado);

      } catch (Exception $e) {
         $resultado['status'] = 'falha';
         print json_encode($resultado);
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
?>