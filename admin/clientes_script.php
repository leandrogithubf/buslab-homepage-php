<?php 
	 // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_CLIENTES") || define("CADASTRO_CLIENTES","cadastroClientes");
defined("EDIT_CLIENTES") || define("EDIT_CLIENTES","editClientes");
defined("DELETA_CLIENTES") || define("DELETA_CLIENTES","deletaClientes");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");

switch ($opx) {

	case CADASTRO_CLIENTES:
		include_once 'clientes_class.php';

		$dados = $_REQUEST;
		$idClientes = cadastroClientes($dados);

		if (is_int($idClientes)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'clientes';
			$log['descricao'] = 'Cadastrou clientes ID('.$idClientes.') nome ('.$dados['nome'].') logo ('.$dados['logo'].') categoria ('.$dados['categoria'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=clientes&acao=listarClientes&mensagemalerta='.urlencode('Clientes criado com sucesso!'));
		} else {
			header('Location: index.php?mod=clientes&acao=listarClientes&mensagemalerta='.urlencode('ERRO ao criar novo Clientes!'));
		}

	break;

	case EDIT_CLIENTES:
		include_once 'clientes_class.php';

		$dados = $_REQUEST;
		$antigo = buscaClientes(array('idclientes'=>$dados['idclientes']));
		$antigo = $antigo[0];

		$idClientes = editClientes($dados);

		if ($idClientes != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'clientes';
			$log['descricao'] = 'Editou clientes ID('.$idClientes.') DE  nome ('.$antigo['nome'].') logo ('.$antigo['logo'].') PARA  nome ('.$dados['nome'].') logo ('.$dados['logo'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=clientes&acao=listarClientes&mensagemalerta='.urlencode('Clientes salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=clientes&acao=listarClientes&mensagemalerta='.urlencode('ERRO ao salvar Clientes!'));
		}

	break;

	case DELETA_CLIENTES:
		include_once 'clientes_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('clientes_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=clientes&acao=listarClientes&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaClientes(array('idclientes'=>$dados['idu']));

			if (deletaClientes($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'clientes';
				$log['descricao'] = 'Deletou clientes ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=clientes&acao=listarClientes&mensagemalerta='.urlencode('Clientes deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=clientes&acao=listarClientes&mensagemalerta='.urlencode('ERRO ao deletar Clientes!'));
			}
		}

	break;

	case SALVA_IMAGEM:

        include_once('clientes_class.php');
		include_once 'includes/fileImage.php';

		$dados = $_POST;
        $idclientes = $dados['idclientes'];
        $imgAntigo = $dados['imagem_antigo']; 
        $tipo_clientes = $dados['tipo_clientes'];
        
        $imagem = $_FILES;
        $antigo = array();
        if(!empty($idclientes) &&  $idclientes > 0){
            $antigo = buscaClientes(array('idclientes'=>$idclientes));
			   $antigo = $antigo[0];
            $antigo['atuacoes'] = explode(",",$antigo['atuacoes']);
        }    
        
        //dados para o crop
        if($tipo_clientes == 'logo'){
            //clientes full
            $width = 167;
            $height = 167;
            // $nomeimagem = fileImage("clientes", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("clientes", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
        else if($tipo_clientes == 'imagem'){
            //clientes mobile
            $width = 409;
            $height = 493;
         //    $nomeimage = fileImage("clientes", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("clientes", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
       	
        //imagem 
        $nomeimagem = fileImage("clientes", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        // $nomeimagem = fileImage("clientes", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
	     
        $caminho = 'files/clientes/'.$nomeimagem;

        if(file_exists($caminho)){
        	//apaga os arquivos anteriores que foram salvos
        	if(!empty($imgAntigo)){
        		$apgImage = apagarImagemClientes($imgAntigo); 
        	}
		 	 
			if(is_numeric($idclientes) && $idclientes > 0){
				//edita o nome do clientes, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
				$clientes = $antigo; 
				$clientes[$tipo_clientes] = $nomeimagem;
				$edita = editClientes($clientes);				 
			} 

            echo '{"status":true, "caminho":"'.$caminho.'", "tipo":"'.$tipo_clientes.'", "idclientes":"'.$idclientes.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "tipo":"'.$tipo_clientes.'", "idclientes":"'.$idclientes.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
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