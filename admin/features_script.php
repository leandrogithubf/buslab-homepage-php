<?php 
	 // Versao do modulo: 3.00.010416

if(!isset($_REQUEST["opx"]) || $_REQUEST["opx"] != "listarFeatures"){
	require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_FEATURES") || define("CADASTRO_FEATURES","cadastroFeatures");
defined("EDIT_FEATURES") || define("EDIT_FEATURES","editFeatures");
defined("DELETA_FEATURES") || define("DELETA_FEATURES","deletaFeatures");
defined("LISTAR_FEATURES") || define("LISTAR_FEATURES","listarFeatures");

defined("PESQUISA_ICONE") || define("PESQUISA_ICONE", "pesquisaIcone");

defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA", "alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO", "alteraOrdemBaixo");


defined("SALVA_GALERIA") || define("SALVA_GALERIA","alteraOrdemBaixoa");
defined("SALVAR_DESCRICAO_IMAGEM") || define("SALVAR_DESCRICAO_IMAGEM","alteraOrdemBaixob");
defined("EXCLUIR_IMAGEM_GALERIA") || define("EXCLUIR_IMAGEM_GALERIA","alteraOrdemBaixoc");
defined("ALTERAR_POSICAO_IMAGEM") || define("ALTERAR_POSICAO_IMAGEM","alteraOrdemBaixoe");
defined("EXCLUIR_IMAGENS_TEMPORARIAS") || define("EXCLUIR_IMAGENS_TEMPORARIAS","alteraOrdemBaixof");

switch ($opx) {

	case CADASTRO_FEATURES:
		include_once 'features_class.php';
		include_once 'includes/fileImage.php';

		$dados = $_REQUEST;
		
        $imagem = $_FILES;

        if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
            $nomeicone = fileImage("features", "", '', $imagem['icone'], 78, 78, 'inside');
            $dados['icone'] = $nomeicone;
        }

		$idFeatures = cadastroFeatures($dados);

		if (is_int($idFeatures)) {  
			 
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'features';
			$log['descricao'] = 'Cadastrou features ID('.$idFeatures.') título ('.$dados['titulo'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') icone ('.$dados['icone'].') ordem ('.$dados['ordem'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=features&acao=listarFeatures&mensagemalerta='.urlencode('Features criado com sucesso!'));
		} else {
			header('Location: index.php?mod=features&acao=listarFeatures&mensagemalerta='.urlencode('ERRO ao criar novo Features!'));
		}

	break;

	case EDIT_FEATURES:
		include_once 'features_class.php';
		include_once 'includes/fileImage.php';

		$dados = $_REQUEST;
        $imagem = $_FILES;
        $antigo = buscaFeatures(array('idfeatures'=>$dados['idfeatures']));
		$antigo = $antigo[0]; 

        if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
            $nomeicone = fileImage("features", "", '', $imagem['icone'], 78, 78, 'inside');
            editarImagemFeatures($antigo['icone']);  
            $dados['icone'] = $nomeicone;
        }

		$idFeatures = editFeatures($dados);

		if ($idFeatures != FALSE) { 

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'features';
			$log['descricao'] = 'Editou features ID('.$idFeatures.') DE  título ('.$antigo['titulo'].') texto ('.$antigo['texto'].') imagem ('.$antigo['imagem'].') icone ('.$antigo['icone'].') ordem ('.$antigo['ordem'].') PARA  nome ('.$dados['nome'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') icone ('.$dados['icone'].') ordem ('.$dados['ordem'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=features&acao=listarFeatures&mensagemalerta='.urlencode('Features salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=features&acao=listarFeatures&mensagemalerta='.urlencode('ERRO ao salvar Features!'));
		}

	break;

	case DELETA_FEATURES:
		include_once 'features_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('features_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=features&acao=listarFeatures&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaFeatures(array('idfeatures'=>$dados['idu']));

			if (deletaFeatures($dados['idu']) == 1) {
				editarImagemFeatures($antigo[0]['icone']);  
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'features';
				$log['descricao'] = 'Deletou features ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=features&acao=listarFeatures&mensagemalerta='.urlencode('Features deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=features&acao=listarFeatures&mensagemalerta='.urlencode('ERRO ao deletar Features!'));
			}
		}

	break; 

	case LISTAR_FEATURES: 

		include_once 'features_class.php';  
        $dados = $_REQUEST;  
        $retorno = array(); 
        $features = buscaFeatures($dados); 
        if(!isset($dados['filtro'])){
	        $retorno['dados'] = $features;
	        $dados['totalRecords'] = true;  
	        $total = buscaFeatures($dados); 
	        $total = $total[0]['totalRecords'];   
	        $retorno['total'] = $total; 
	        if($total > 0 && isset($dados['limit'])){ 
	            $paginas = ceil($total / $dados['limit']);
	            $retorno['totalPaginas'] = $paginas;
	        }
    	}
        print json_encode($retorno);
	break; 

	//SALVA IMAGENS DA GALERIA 
    case SALVA_GALERIA:
            
        include_once('features_class.php');
		include_once 'includes/fileImage.php';
            
		$dados = $_POST;
        $idfeatures = $dados['idfeatures'];
        $posicao = $dados['posicao']; 

        $imagem = $_FILES;
        
        $caminhopasta = "files/features";
        if(!file_exists($caminhopasta)){
        	mkdir($caminhopasta, 0777);
        }  
       
        //galeria grande
      	$nomeimagem = fileImage("features", "", "", $imagem['imagem'], 800, 800, 'inside');
      	$thumb = fileImage("features", $nomeimagem, "thumb", $imagem['imagem'], 102, 102, 'crop');
       
        $caminho = $caminhopasta.'/thumb_'.$nomeimagem;

        //vai cadastrar se já tiver o id do features, senao so fica na pasta.
        $idfeatures_imagem = $nomeimagem; 

        if(is_numeric($idfeatures)){
        	//CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
			$imagem['idfeatures'] = $idfeatures;
			$imagem['descricao_imagem'] = "";
			$imagem['posicao_imagem'] = $posicao;
			$imagem['nome_imagem'] = $nomeimagem; 
			$idfeatures_imagem = salvaImagemFeatures($imagem);	
        } 
       
        print '{"status":true, "caminho":"'.$caminho.'", "idfeatures":"'.$idfeatures.'", "idfeatures_imagem":"'.$idfeatures_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
          
    break; 
 
    case SALVAR_DESCRICAO_IMAGEM:
		include_once('features_class.php');
		$dados = $_POST;

		$imagem = buscaFeatures_imagem(array("idfeatures_imagem"=>$dados['idImagem']));
		$imagem = $imagem[0];
		if($imagem){
			$imagem['descricao_imagem'] = $dados['descricao'];
			if(editFeatures_imagem($imagem)){
				print '{"status":true}';
			}else{
				print '{"status":false}';
			}
		}else{
			print '{"status":false}';
		}
		
	break; 

	//EXCLUI A IMAGEM DA GALERIA SELECIONADA
	case EXCLUIR_IMAGEM_GALERIA: 
		include_once('features_class.php');
		$dados = $_POST;  
		$idfeatures = $dados['idfeatures'];
		$idfeatures_imagem = $dados['idfeatures_imagem'];
		$imagem = $dados['imagem'];
		$descricao = $dados['descricao']; 

		$retorno['status'] = apagarImagemFeatures($imagem);
		if(is_numeric($idfeatures) && $idfeatures > 0){ 
			//ESTA EDITANDO OS DADOS, APAGAR IMAGEM DA PASTA E DO BANCO REORDENANDO A POSICAO
			//$retorno['status'] = apagarImagemFeatures($idfeatures, $imagem, $idfeatures_imagem, $descricao); 
			deletarImagemFeaturesGaleria($idfeatures_imagem, $idfeatures);
		}  
		print json_encode($retorno); 
	break;

	//ALTERAR POSICAO DA IMAGEM
	case ALTERAR_POSICAO_IMAGEM: 
		include_once('features_class.php');
		$dados = $_POST;  
		alterarPosicaoImagemFeatures($dados);
		print '{"status":true}'; 
	break;

	//EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
	case EXCLUIR_IMAGENS_TEMPORARIAS: 
		include_once('features_class.php');
		$dados = $_POST;	 
		if(isset($dados['imagem_features'])){
			$imgs = $dados['imagem_features'];
			foreach ($imgs as $key => $value) { 
				apagarImagemFeatures($value);
			}
		} 
		print '{"status":true}'; 
	break;

    case PESQUISA_ICONE:
        include_once('features_class.php');
        $dados = $_REQUEST;
        $icone = buscaFW3(array('nome' => $dados['nome'], 'ordem' => 'nome', 'dir' => 'asc'));
        if (!empty($icone)) {
            $html = '';
            foreach ($icone as $key => $i) {
                $html .= '<div style="width:6%; display: inline-block;" data-id="' . $i['idfw'] . '" data-toggle="tooltip" title="' . $i['nome'] . '">';
                $html .= '    <i class="fa fa-' . $i['nome'] . ' icone_icone" data-id="' . $i['idfw'] . '" data-nome="' . $i['nome'] . '" style="padding:11px; cursor: pointer;"></i>';
                $html .= '</div>';
            }
        } else {
            $html = '<span>Nenhum icone encontrado</span>';
        }
        echo $html;

	break;



	case ALTERA_ORDEM_CIMA:
		include_once("features_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$features = buscaFeatures(array('idfeatures' => $dados['idfeatures']));
			$features = $features[0];

			$ordem = $features['ordem'] - 1;

			$featuresAux = buscaFeatures(array('order' => $ordem));

			if (!empty($featuresAux)) {

				$dadosUpdate = array();
				$dadosUpdate['idfeatures'] = $dados['idfeatures'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemFeatures($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idfeatures'] = $featuresAux[0]['idfeatures'];
				$dadosUpdate2['ordem'] = intval($features['ordem']);
				editOrdemFeatures($dadosUpdate2);
			}

			print json_encode($resultado);

		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case ALTERA_ORDEM_BAIXO:
		include_once("features_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$features = buscaFeatures(array('idfeatures' => $dados['idfeatures']));
			$features = $features[0];

			$ordem = $features['ordem'] + 1;

			$featuresAux = buscaFeatures(array('order' => $ordem));

			if (!empty($featuresAux)) {
				$dadosUpdate = array();
				$dadosUpdate['idfeatures'] = $dados['idfeatures'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemFeatures($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idfeatures'] = $featuresAux[0]['idfeatures'];
				$dadosUpdate2['ordem'] = intval($features['ordem']);
				editOrdemFeatures($dadosUpdate2);
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