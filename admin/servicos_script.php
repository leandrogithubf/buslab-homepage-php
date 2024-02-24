<?php 
	 // Versao do modulo: 3.00.010416
if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

if($_REQUEST['opx'] != 'listarRecursos'){
   require_once 'includes/verifica.php'; // checa user logado
}

$opx = $_REQUEST["opx"];

defined("INVERTE_STATUS") || define("INVERTE_STATUS", "inverteStatus");
defined("CADASTRO_SERVICOS") || define("CADASTRO_SERVICOS","cadastroServicos");
defined("EDIT_SERVICOS") || define("EDIT_SERVICOS","editServicos");
defined("DELETA_SERVICOS") || define("DELETA_SERVICOS","deletaServicos");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");
defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA", "alteraOrdemCima");
defined("ALTERA_ORDEM_CIMA_REC") || define("ALTERA_ORDEM_CIMA_REC", "alteraOrdemCimaRec");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO", "alteraOrdemBaixo");
defined("ALTERA_ORDEM_BAIXO_REC") || define("ALTERA_ORDEM_BAIXO_REC", "alteraOrdemBaixoRec");
defined("LISTAR_RECURSOS") || define("LISTAR_RECURSOS", "listarRecursos");
defined("ATUALIZA_ORDEM_REC") || define("ATUALIZA_ORDEM_REC", "atualizaOrdemRec");

switch ($opx) {

	case CADASTRO_SERVICOS:
		include_once 'servicos_class.php';
		include_once 'includes/fileImage.php';

		$dados = $_REQUEST;
		$imagens = $_FILES;

		$imagem = $_FILES;

        if (isset($_FILES['icone2']) && $_FILES['icone2']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagem['icone2'], 90, 90, 'inside');
            $nomeicone2 = fileImage("servicos", $nomeicone, 'medium', $imagem['icone2'], 92, 92, 'inside');
            $nomeiconenegativo = fileImage("servicos", $nomeicone, 'negativo', $imagem['icone3'], 90, 90, 'inside');
            $dados['icone2'] = $nomeicone;
        }

		$caminhopasta = "files/recursos";
        if(!file_exists($caminhopasta)){
        	mkdir($caminhopasta, 0777);
        }

        $arrayImg = "";
        if(!empty($imagens['recursos'])){
            foreach($imagens['recursos'] as $key => $imgArray){
                foreach($imgArray as $keyName => $img){
                    $arrayImg[$keyName][$key] = $img['imagem'];              
                }
            }
            foreach($arrayImg as $img){
                $nomeimagem[] = fileImage("recursos", "", "", $img, 70, 70, 'resize');
            }
            foreach($dados['recursos'] as $keys => $recursos){
                foreach($nomeimagem as $key => $names){
                    $dados['recursos'][$key]['imagem'] = $names;
                }
            }
        }

		$idServicos = cadastroServicos($dados);
		// $idRecursos = cadastroRecursos($dados);

		if (is_int($idServicos)) {
			foreach($dados['recursos'] as $keys => $rec){
                $dados['recursos'][$keys]['idservicos'] = $idServicos;
                cadastroRecursos($dados['recursos'][$keys]);
                // print_r($dados);die;
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'servicos';
			$log['avaliacao'] = 'Cadastrou servicos ID('.$idServicos.') titulo ('.$dados['titulo'].') resumo ('.$dados['resumo'].') descricao ('.$dados['descricao'].') idioma ('.$dados['ididiomas'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Servicos criado com sucesso!'));
		} else {
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('ERRO ao criar novo Servicos!'));
		}

		break;

	case EDIT_SERVICOS:
		include_once 'servicos_class.php';
		include_once "includes/fileImage.php";
		
		$dados = $_REQUEST;
		$imagens = $_FILES;

		$antigo = buscaServicos(array('idservicos'=>$dados['idservicos']));
		$antigo = $antigo[0];

        $arrayImg = "";

        if (isset($_FILES['icone2']) && $_FILES['icone2']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagens['icone2'], 90, 90, 'inside');
            $nomeicone2 = fileImage("servicos", $nomeicone, 'medium', $imagens['icone2'], 92, 92, 'inside');
            $nomeiconenegativo = fileImage("servicos", $nomeicone, 'negativo', $imagem['icone3'], 90, 90, 'inside');
            editarImagemServicos($antigo['icone']);  
            $dados['icone2'] = $nomeicone;
        }
        elseif(isset($_FILES['icone3']) && $_FILES['icone3']['error'] == 0){
        	$nomeiconenegativo = fileImage("servicos", $antigo['icone'], 'negativo', $imagens['icone3'], 90, 90, 'inside');
        }

        foreach($imagens['recursos'] as $key => $imgArray){
            foreach($imgArray as $keyName => $img){
            	if(!empty($img['imagem'])){
            		$arrayImg[$keyName][$key] = $img['imagem'];
        		}
            }
        }

        $idServicos = editServicos($dados);

        foreach($arrayImg as $key => $imgsUpload){
            if(!empty($imgsUpload['tmp_name'])){
                apagarImagemRecursos($dados['recursos'][$key]['imagem']);
                $nomeimagem[] = fileImage("recursos", "", "", $imgsUpload, 70, 70, 'resize');
                foreach($nomeimagem as $names){
                    $dados['recursos'][$key]['imagem'] = $names;
                }
            }
            elseif($dados['recursos'][$keys]['idrecursos'] != 0){
            	$antigoRecurso = buscaRecursos(array('idrecursos'=>$dados['recursos'][$key]['idrecursos'], 'idservicos' => $idServicos));
            	$dados['recursos'][$key]['imagem'] = $antigoRecurso[0]['imagem'];
            }
        }

		foreach($dados['recursos'] as $keys => $recursos){
			if($dados['recursos'][$keys]['idrecursos'] == 0 && $dados['recursos'][$keys]['excluirRecurso'] != 0){
				$dados['recursos'][$keys]['idservicos'] = $idServicos;
				$ordem = buscaRecursos(array('max'=>'ordem'));
				if (!empty($ordem)){
					$ordem = $ordem[0];	
					$dados['recursos'][$keys]['ordem'] = (int)$ordem['max']+1;	
				}
				cadastroRecursos($dados['recursos'][$keys]);
			}
			elseif($dados['recursos'][$keys]['excluirRecurso'] == 0){
				$antigoRecurso = buscaRecursos(array('idrecursos'=>$dados['recursos'][$keys]['idrecursos']));
				apagarImagemRecursos($antigoRecurso[0]['imagem']);
				deletaRecursos2($idServicos,$dados['recursos'][$keys]['idrecursos']);
			}
			else{
	            $dados['recursos'][$keys]['idservicos'] = $idServicos;
	            editRecursos($dados['recursos'][$keys]);
	        }
        }

		if ($idServicos != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'servicos';
			$log['avaliacao'] = 'Editou servicos ID('.$idServicos.') DE titulo ('.$antigo['titulo'].') resumo ('.$antigo['resumo'].') descricao ('.$antigo['descricao'].') idioma ('.$antigo['ididiomas'].') PARA titulo ('.$dados['titulo'].') resumo ('.$dados['resumo'].') descricao ('.$dados['descricao'].') idioma ('.$dados['ididiomas'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Servicos salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('ERRO ao salvar Servicos!'));
		}

		break;

	case DELETA_SERVICOS:
		include_once 'servicos_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('servicos_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaServicos(array('idservicos'=>$dados['idu']));

			// apagarImagemServicos($antigo[0]['thumbs']);
			// apagarImagemServicos($antigo[0]['banner_topo']);

			$antigoRecursos = buscaRecursos(array('idservicos'=>$dados['idu']));

			foreach ($antigoRecursos as $key => $oldRec) {
				apagarImagemRecursos($oldRec['imagem']);
			}

			if (deletaServicos($dados['idu']) == 1) {
				deletaRecursos($dados['idu']);
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'servicos';
				$log['avaliacao'] = 'Deletou servicos ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Servicos deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('ERRO ao deletar Servicos!'));
			}
		}

	break;

	case SALVA_IMAGEM:
		include_once('servicos_class.php');
		include_once 'includes/fileImage.php';

		$dados = $_POST;
        $idservicos = $dados['idservicos'];
        $imgAntigo = $dados['imagem_antigo']; 
        $tipo_banner = $dados['tipo'];
        
        $imagem = $_FILES;
        $antigo = array();
        if(!empty($idservicos) &&  $idservicos > 0){
            $antigo = buscaServicos(array('idservicos'=>$idservicos));
			$antigo = $antigo[0];
        }    
        
        //dados para o crop
        if($tipo_banner == 'thumbs'){
            //banner thumb
            $width = 312;
            $height = 225;
        }
        else if($tipo_banner == 'banner_topo'){
            //banner topo
            $width = 1220;
            $height = 523;
        }
       	
        //imagem 
        $nomeimagem = fileImage("servicos", "", "", $imagem['imagem'], $width, $height, 'resize'); 
        // $nomeimagem = fileImage("servicos", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');
	     
        $caminho = 'files/servicos/'.$nomeimagem;

        if(file_exists($caminho)){
        	//apaga os arquivos anteriores que foram salvos
        	if(!empty($imgAntigo)){
        		$apgImage = apagarImagemServicos($imgAntigo); 
        	}
		 	 
			if(is_numeric($idservicos) && $idservicos > 0){
				//edita o nome do banner, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
				$servicos = $antigo; 
				$servicos[$tipo_banner] = $nomeimagem;
				$edita = editServicos($servicos);
			} 
            echo '{"status":true, "caminho":"'.$caminho.'", "tipo":"'.$tipo_banner.'", "idservicos":"'.$idservicos.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "tipo":"'.$tipo_banner.'", "idservicos":"'.$idservicos.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
        }
	break;

	case INVERTE_STATUS:
		include_once("servicos_class.php");
		include_once("includes/functions.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';

		$tabela = 'servicos';
		$id = 'idservicos';

		try {
			$servicos = buscaServicos(array('idservicos' => $dados['idservicos']));
			$servicos = $servicos[0];

			// print_r($depoimento);
			if($servicos['status'] == 1){
				$status = 0;
			}
			else{
				$status = 1;
			}

			$dadosUpdate = array();
			$dadosUpdate['idservicos'] = $dados['idservicos'];
			$dadosUpdate['status'] = $status;
			inverteStatus($dadosUpdate,$tabela,$id);

			print json_encode($resultado);
		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case ALTERA_ORDEM_CIMA:
		include_once("servicos_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$servicos = buscaServicos(array('idservicos' => $dados['idservicos']));
			$servicos = $servicos[0];

			$ordem = $servicos['ordem'] - 1;

			$servicosAux = buscaServicos(array('order' => $ordem));

			if (!empty($servicosAux)) {

				$dadosUpdate = array();
				$dadosUpdate['idservicos'] = $dados['idservicos'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemServicos($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idservicos'] = $servicosAux[0]['idservicos'];
				$dadosUpdate2['ordem'] = intval($servicos['ordem']);
				editOrdemServicos($dadosUpdate2);
			}

			print json_encode($resultado);

		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case ALTERA_ORDEM_CIMA_REC:
		include_once("servicos_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$recursos = buscaRecursos(array('idrecursos' => $dados['idrecursos']));
			$recursos = $recursos[0];

			$ordem = $recursos['ordem'] - 1;

			$recursosAux = buscaRecursos(array('order' => $ordem, 'idservicos' => $dados['idservicos']));

			if (!empty($recursosAux)) {

				$dadosUpdate = array();
				$dadosUpdate['idrecursos'] = $dados['idrecursos'];
				$dadosUpdate['idservicos'] = $dados['idservicos'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemRecursos($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idrecursos'] = $recursosAux[0]['idrecursos'];
				$dadosUpdate2['idservicos'] = $recursosAux[0]['idservicos'];
				$dadosUpdate2['ordem'] = intval($recursos['ordem']);
				editOrdemRecursos($dadosUpdate2);
			}

			print json_encode($resultado);

		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case ALTERA_ORDEM_BAIXO:
		include_once("servicos_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$servicos = buscaServicos(array('idservicos' => $dados['idservicos']));
			$servicos = $servicos[0];

			$ordem = $servicos['ordem'] + 1;

			$servicosAux = buscaServicos(array('order' => $ordem));

			if (!empty($servicosAux)) {
				$dadosUpdate = array();
				$dadosUpdate['idservicos'] = $dados['idservicos'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemServicos($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idservicos'] = $servicosAux[0]['idservicos'];
				$dadosUpdate2['ordem'] = intval($servicos['ordem']);
				editOrdemServicos($dadosUpdate2);
			}

			print json_encode($resultado);

		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case ALTERA_ORDEM_BAIXO_REC:
		include_once("servicos_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$recursos = buscaRecursos(array('idrecursos' => $dados['idrecursos']));
			$recursos = $recursos[0];

			$ordem = $recursos['ordem'] + 1;

			$recursosAux = buscaRecursos(array('order' => $ordem, 'idservicos' => $dados['idservicos']));

			if (!empty($recursosAux)) {

				$dadosUpdate = array();
				$dadosUpdate['idrecursos'] = $dados['idrecursos'];
				$dadosUpdate['idservicos'] = $dados['idservicos'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemRecursos($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idrecursos'] = $recursosAux[0]['idrecursos'];
				$dadosUpdate2['idservicos'] = $recursosAux[0]['idservicos'];
				$dadosUpdate2['ordem'] = intval($recursos['ordem']);
				editOrdemRecursos($dadosUpdate2);
			}

			print json_encode($resultado);

		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case LISTAR_RECURSOS:

		include_once 'servicos_class.php';
		include_once 'includes/functions.php';

		$dados = $_REQUEST;

		$retorno = array();
		$recursos = buscaRecursos($dados);
		foreach($recursos as $key => $r){
	        if(strlen($recursos[$key]['icone']) < 4){
	            $recursos[$key]['icone'] = buscaFW3(array("idfw"=>$r['icone']));
	        }else{
	            $recursos[$key]['icone'] = array(array("idfw" => 0,"nome" => $recursos[$key]['icone']));
	        }
	    }
		// shuffle($recursos);
		$retorno['dados'] = $recursos;

		if (!empty($recursos)) {
			$dados['totalRecords'] = true;
			$total = buscaRecursos($dados);
			$retorno['total'] = $total[0]['totalRecords'];

			if (count($total) > 0 && isset($dados['limit']) && $dados['limit'] > 0) {
				$paginas = ceil($total[0]['totalRecords'] / $dados['limit']);
				$retorno['totalPaginas'] = $paginas;
			}
		} else {
			$retorno['totalPaginas'] = 0;
			$retorno['total'] = 0;
		}
		print json_encode($retorno);

	break;

	case ATUALIZA_ORDEM_REC:

		include_once 'servicos_class.php';
		include_once 'includes/functions.php';

		$dados = $_REQUEST;

		$retorno = array();
		$recursos = buscaRecursos($dados);
		shuffle($recursos);
		$retorno['dados'] = $recursos;

		if (!empty($recursos)) {
			$dados['totalRecords'] = true;
			$total = buscaRecursos($dados);
			$retorno['total'] = $total[0]['totalRecords'];

			if (count($total) > 0 && isset($dados['limit']) && $dados['limit'] > 0) {
				$paginas = ceil($total[0]['totalRecords'] / $dados['limit']);
				$retorno['totalPaginas'] = $paginas;
			}
		} else {
			$retorno['totalPaginas'] = 0;
			$retorno['total'] = 0;
		}
		print json_encode($retorno);

	break;

	case VERIFICAR_URLREWRITE:

		include_once('servicos_class.php'); 
		include_once('includes/functions.php');
		
		$dados = $_POST;
		 
		$urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $dados['urlrewrite'])));
 		
 		if($dados['idservicos'] && $dados['idservicos'] <= 0){
 			$url = buscaServicos(array("urlamigavel"=>$urlrewrite)); 	
 		}else{ 
 			$url = buscaServicos(array("urlamigavel"=>$urlrewrite,"not_idservicos"=>$dados['idservicos'])); 
 		} 

 		if(empty($url)){ 
 			print '{"status":true,"url":"'.$urlrewrite.'"}';
 		}else{
 			print '{"status":false}';
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