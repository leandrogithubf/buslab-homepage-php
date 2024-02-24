<?php 
	 // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_COMO_FUNCIONA") || define("CADASTRO_COMO_FUNCIONA","cadastroComo_funciona");
defined("EDIT_COMO_FUNCIONA") || define("EDIT_COMO_FUNCIONA","editComo_funciona");
defined("DELETA_COMO_FUNCIONA") || define("DELETA_COMO_FUNCIONA","deletaComo_funciona");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA","alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO","alteraOrdemBaixo");

switch ($opx) {

	case CADASTRO_COMO_FUNCIONA:
		include_once 'como_funciona_class.php';

		$dados = $_REQUEST;
		$idComo_funciona = cadastroComo_funciona($dados);

		if (is_int($idComo_funciona)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'como_funciona';
			$log['descricao'] = 'Cadastrou como_funciona ID('.$idComo_funciona.') nome ('.$dados['nome'].') logo ('.$dados['logo'].') idioma ('.$dados['idioma'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') servicos ('.$dados['servicos'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=como_funciona&acao=listarComo_funciona&mensagemalerta='.urlencode('Como Funciona criado com sucesso!'));
		} else {
			header('Location: index.php?mod=como_funciona&acao=listarComo_funciona&mensagemalerta='.urlencode('ERRO ao criar novo Como Funciona!'));
		}

	break;

	case EDIT_COMO_FUNCIONA:
		include_once 'como_funciona_class.php';

		$dados = $_REQUEST;
		$antigo = buscaComo_funciona(array('idcomo_funciona'=>$dados['idcomo_funciona']));
		$antigo = $antigo[0];

		$idComo_funciona = editComo_funciona($dados);

		if ($idComo_funciona != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'como_funciona';
			$log['descricao'] = 'Editou como_funciona ID('.$idComo_funciona.') DE  nome ('.$antigo['nome'].') logo ('.$antigo['logo'].') idioma ('.$antigo['idioma'].') texto ('.$antigo['texto'].') imagem ('.$antigo['imagem'].') servicos ('.$antigo['servicos'].') PARA  nome ('.$dados['nome'].') logo ('.$dados['logo'].') idioma ('.$dados['idioma'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') servicos ('.$dados['servicos'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=como_funciona&acao=listarComo_funciona&mensagemalerta='.urlencode('Como Funciona salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=como_funciona&acao=listarComo_funciona&mensagemalerta='.urlencode('ERRO ao salvar Como Funciona!'));
		}

	break;

	case DELETA_COMO_FUNCIONA:
		include_once 'como_funciona_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('como_funciona_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=como_funciona&acao=listarComo_funciona&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaComo_funciona(array('idcomo_funciona'=>$dados['idu']));

			if (deletaComo_funciona($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'como_funciona';
				$log['descricao'] = 'Deletou como_funciona ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=como_funciona&acao=listarComo_funciona&mensagemalerta='.urlencode('Como Funciona deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=como_funciona&acao=listarComo_funciona&mensagemalerta='.urlencode('ERRO ao deletar Como Funciona!'));
			}
		}

	break;

	case SALVA_IMAGEM:

        include_once('como_funciona_class.php');
		include_once 'includes/fileImage.php';

		$dados = $_POST;
        $idcomo_funciona = $dados['idcomo_funciona'];
        $imgAntigo = $dados['imagem_antigo']; 
        $tipo_como_funciona = $dados['tipo_como_funciona'];
        
        $imagem = $_FILES;
        $antigo = array();
        if(!empty($idcomo_funciona) &&  $idcomo_funciona > 0){
            $antigo = buscaComo_funciona(array('idcomo_funciona'=>$idcomo_funciona));
			$antigo = $antigo[0];
        }    
        
        //dados para o crop
        if($tipo_como_funciona == 'logo'){
            //como_funciona full
            $width = 195;
            $height = 132;
            // $nomeimagem = fileImage("como_funciona", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("como_funciona", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
        else if($tipo_como_funciona == 'imagem'){
            //como_funciona mobile
            $width = 1920;
            $height = 676;
         //    $nomeimage = fileImage("como_funciona", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("como_funciona", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
       	
        //imagem 
        $nomeimagem = fileImage("como_funciona", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        // $nomeimagem = fileImage("como_funciona", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
	     
        $caminho = 'files/como_funciona/'.$nomeimagem;

        if(file_exists($caminho)){
        	//apaga os arquivos anteriores que foram salvos
        	if(!empty($imgAntigo)){
        		$apgImage = apagarImagemComo_funciona($imgAntigo); 
        	}
		 	 
			if(is_numeric($idcomo_funciona) && $idcomo_funciona > 0){
				//edita o nome do como_funciona, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
				$como_funciona = $antigo; 
				$como_funciona[$tipo_como_funciona] = $nomeimagem;
				$edita = editComo_funciona($como_funciona);				 
			} 

            echo '{"status":true, "caminho":"'.$caminho.'", "tipo":"'.$tipo_como_funciona.'", "idcomo_funciona":"'.$idcomo_funciona.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "tipo":"'.$tipo_como_funciona.'", "idcomo_funciona":"'.$idcomo_funciona.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
        }

    break;

    case ALTERA_ORDEM_CIMA:
      include_once("como_funciona_class.php");

      $dados = $_REQUEST; 
      $resultado['status'] = 'sucesso';

      try {

         $como_funciona = buscaComo_funciona(array('idcomo_funciona'=>$dados['idcomo_funciona']));
         $como_funciona = $como_funciona[0];
         $ordemAux = 0;
         $ordem = $como_funciona['ordem'];

         while($ordemAux == 0)
         {
             $ordem = $ordem - 1;
             $como_funcionaAux = buscaComo_funciona(array('order'=>$ordem));

             if(!empty($como_funcionaAux)){
               $como_funcionaAux = $como_funcionaAux[0];
               $ordemAux = $como_funcionaAux['ordem'];
             }
         }

         if(!empty($como_funcionaAux)){

            $como_funcionaAux['ordem'] = $como_funciona['ordem'];
            $como_funciona['ordem'] = $ordemAux;

            editComo_funciona($como_funciona);
            editComo_funciona($como_funcionaAux);
          }

         print json_encode($resultado);

      } catch (Exception $e) {
         $resultado['status'] = 'falha';
         print json_encode($resultado);
      }
   break;

   case ALTERA_ORDEM_BAIXO:
      include_once("como_funciona_class.php");

      $dados = $_REQUEST; 
      $resultado['status'] = 'sucesso';

      try {
         $como_funciona = buscaComo_funciona(array('idcomo_funciona'=>$dados['idcomo_funciona']));
         $como_funciona = $como_funciona[0];
         $ordemAux = 0;
         $ordem = $como_funciona['ordem'];

         while($ordemAux == 0)
         {
             $ordem = $ordem + 1;
             $como_funcionaAux = buscaComo_funciona(array('order'=>$ordem));

             if(!empty($como_funcionaAux)){
               $como_funcionaAux = $como_funcionaAux[0];
               $ordemAux = $como_funcionaAux['ordem'];
             }

         }

         if(!empty($como_funcionaAux)){
            $como_funcionaAux['ordem'] = $como_funciona['ordem'];
            $como_funciona['ordem'] = $ordemAux;

            editComo_funciona($como_funciona);
            editComo_funciona($como_funcionaAux);
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