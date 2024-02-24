<?php
// Versao do modulo: 2.20.130114

require_once 'includes/verifica.php'; // checa user logado
 

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_BANNER") || define("CADASTRO_BANNER","cadastroBanner");
defined("EDIT_BANNER") || define("EDIT_BANNER","editBanner");
defined("DELETA_BANNER") || define("DELETA_BANNER","deletaBanner");
defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA","alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO","alteraOrdemBaixo");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("DELETA_CADASTRO_TEMPORARIO") || define("DELETA_CADASTRO_TEMPORARIO","deletaCadastroTemporario");
defined("BUSCAR_BANNER") || define("BUSCAR_BANNER","buscarBanner");

defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");

switch ($opx) {

	case CADASTRO_BANNER:
		include_once 'banner_class.php';

		$dados = $_REQUEST;

		$idtemporario = $dados['idbanner'];
		$idbanner = cadastroBanner($dados);

		if(!is_numeric($idtemporario) && file_exists('files/banner/'.$idtemporario.'/')){
			rename('files/banner/'.$idtemporario, 'files/banner/'.$idbanner);
		}

		//FIM REGRA IMAGEM
		if ($idbanner) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'banner';
			$log['descricao'] = 'Cadastrou banner ID('.$idbanner.') nome ('.$dados['nome'].') status('.$dados['status'].') link ('.$dados['link'].') descricao ('.$dados['descricao'].') banner_full ('.$dados['banner_full'].') banner_mobile ('.$dados['banner_mobile'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=banner&acao=listarBanner&mensagemalerta='.urlencode('banner criado com sucesso!'));
		} else {
			header('Location: index.php?mod=banner&acao=listarBanner&mensagemalerta='.urlencode('ERRO ao criar novo banner!'));
		}

	break;

	case EDIT_BANNER:

		include_once 'banner_class.php';

		$dados = $_REQUEST;

		$antigo = buscaBanner(array('idbanner'=>$dados['idbanner']));
		$antigo = $antigo[0];

		$idbanner = editBanner($dados);

		if ($idbanner != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'banner';
			$log['descricao'] = 'Editou banner ID('.$idBanner.') DE  nome ('.$antigo['nome'].') status ('.$antigo['status'].') link('.$antigo['link'].') banner_full ('.$antigo['banner_full'].') banner_mobile ('.$antigo['banner_mobile'].') PARA  nome ('.$dados['nome'].') status ('.$dados['status'].') banner_full ('.$dados['banner_full'].') banner_mobile ('.$dados['banner_mobile'].') link('.$dados['link'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=banner&acao=listarBanner&mensagemalerta='.urlencode('Banner salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=banner&acao=listarBanner&mensagemalerta='.urlencode('ERRO ao salvar Banner!'));
		}

	break;



	case DELETA_BANNER:
		include_once 'banner_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('banner_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=banner&acao=listarbanner&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaBanner(array('idbanner'=>$dados['idu']));
			$antigo = $antigo[0];
			$antigo['idbanner'];

			if (deletaBanner($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'banner';
				$log['descricao'] = 'Deletou banner ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=banner&acao=listarBanner&mensagemalerta='.urlencode('Banner deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=banner&acao=listarBanner&mensagemalerta='.urlencode('ERRO ao deletar Banner!'));
			}
		}

	break;

    case DELETA_CADASTRO_TEMPORARIO:

		include_once('banner_class.php');
		$dados = $_POST; 
 		 
		print '{"status":true}';

	break;

    case ALTERA_ORDEM_CIMA:
		include_once("banner_class.php");

		$dados = $_REQUEST; 
		$resultado['status'] = 'sucesso';

		try {

            $banner = buscaBanner(array('idbanner'=>$dados['idbanner']));
 			$banner = $banner[0];
			$ordemAux = 0;
			$ordem = $banner['ordem'];

			while($ordemAux == 0)
			{
				 $ordem = $ordem - 1;
				 $bannerAux = buscaBanner(array('order'=>$ordem));

				 if(!empty($bannerAux)){
				 	$bannerAux = $bannerAux[0];
				 	$ordemAux = $bannerAux['ordem'];
				 }
			}

			if(!empty($bannerAux)){

				$bannerAux['ordem'] = $banner['ordem'];
				$banner['ordem'] = $ordemAux;

				editBanner($banner);
				editBanner($bannerAux);
			 }

			print json_encode($resultado);

		} catch (Exception $e) {
    		$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

    case ALTERA_ORDEM_BAIXO:
		include_once("banner_class.php");

		$dados = $_REQUEST; 
		$resultado['status'] = 'sucesso';

		try {
			$banner = buscaBanner(array('idbanner'=>$dados['idbanner']));
			$banner = $banner[0];
			$ordemAux = 0;
			$ordem = $banner['ordem'];

			while($ordemAux == 0)
			{
				 $ordem = $ordem + 1;
				 $bannerAux = buscaBanner(array('order'=>$ordem));

				 if(!empty($bannerAux)){
				 	$bannerAux = $bannerAux[0];
				 	$ordemAux = $bannerAux['ordem'];
				 }

			}

			if(!empty($bannerAux)){
				$bannerAux['ordem'] = $banner['ordem'];
				$banner['ordem'] = $ordemAux;

				editBanner($banner);
				editBanner($bannerAux);
			 }

			print json_encode($resultado);

		} catch (Exception $e) {
    		$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

    ////IMAGENS
	//SALVA IMAGEM DO BANNER FULL OU MOBILE
    case SALVA_IMAGEM:

        include_once('banner_class.php');
		include_once 'includes/fileImage.php';

		$dados = $_POST;
        $idbanner = $dados['idbanner'];
        $imgAntigo = $dados['imagem_antigo']; 
        $tipo_banner = $dados['tipo_banner'];
        
        $imagem = $_FILES;
        $antigo = array();
        if(!empty($idbanner) &&  $idbanner > 0){
            $antigo = buscaBanner(array('idbanner'=>$idbanner));
			$antigo = $antigo[0];
        }    
        
        //dados para o crop
        if($tipo_banner == 'banner_full'){
            //banner full
            $width = 1920;
            $height = 1080;
            // $nomeimagem = fileImage("banner", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("banner", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
        else if($tipo_banner == 'banner_mobile'){
            //banner mobile
            $width = 361;
            $height = 521;
         //    $nomeimage = fileImage("banner", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        	// $nomeimagem = fileImage("banner", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
        }
       	
        //imagem 
        if($dados['flutuante'] == "S"){
         $nomeimagem = fileImage("banner", "", "", $imagem['imagem'], 1162, 654, 'resize'); 
        }
        else{
         $nomeimagem = fileImage("banner", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        }
        // $nomeimagem = fileImage("banner", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
	     
        $caminho = 'files/banner/'.$nomeimagem;

        if(file_exists($caminho)){
        	//apaga os arquivos anteriores que foram salvos
        	if(!empty($imgAntigo)){
        		$apgImage = apagarImagemBanner($imgAntigo); 
        	}
		 	 
			if(is_numeric($idbanner) && $idbanner > 0){
				//edita o nome do banner, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
				$banner = $antigo; 
				$banner[$tipo_banner] = $nomeimagem; 
				$edita = editBanner($banner);				 
			} 
            echo '{"status":true, "caminho":"'.$caminho.'", "tipo":"'.$tipo_banner.'", "idbanner":"'.$idbanner.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "tipo":"'.$tipo_banner.'", "idbanner":"'.$idbanner.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
        }

    break;


	case BUSCAR_BANNER:

		include_once('banner_class.php');
		$dados = $_POST;
		$banner = buscaBanner(array("status"=>"A","ordem"=>"ordem asc"));
		print json_encode($banner);

		break;
		
	case INVERTE_STATUS:
		include_once("banner_class.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';
		include_once("includes/functions.php");
		$tabela = 'banner';
		$id = 'idbanner';

		try {
			$banner = buscaBanner(array('idbanner' => $dados['idbanner']));
			$banner = $banner[0];

			// print_r($banner);
			if($banner['status'] == 1){
				$status = 0;
			}
			else{
				$status = 1;
			}

			$dadosUpdate = array();
			$dadosUpdate['idbanner'] = $dados['idbanner'];
			$dadosUpdate['status'] = $status;
			inverteStatus($dadosUpdate,$tabela,$id);

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
