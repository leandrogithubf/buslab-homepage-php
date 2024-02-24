<?php 
	 // Versao do modulo: 3.00.010416

if(!isset($_REQUEST["opx"]) || $_REQUEST["opx"] != "listarVantagens"){
	require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_VANTAGENS") || define("CADASTRO_VANTAGENS","cadastroVantagens");
defined("EDIT_VANTAGENS") || define("EDIT_VANTAGENS","editVantagens");
defined("DELETA_VANTAGENS") || define("DELETA_VANTAGENS","deletaVantagens");
defined("LISTAR_VANTAGENS") || define("LISTAR_VANTAGENS","listarVantagens");

defined("PESQUISA_ICONE") || define("PESQUISA_ICONE", "pesquisaIcone");

defined("ALTERA_ORDEM_CIMA") || define("ALTERA_ORDEM_CIMA", "alteraOrdemCima");
defined("ALTERA_ORDEM_BAIXO") || define("ALTERA_ORDEM_BAIXO", "alteraOrdemBaixo");


defined("SALVA_GALERIA") || define("SALVA_GALERIA","alteraOrdemBaixoa");
defined("SALVAR_DESCRICAO_IMAGEM") || define("SALVAR_DESCRICAO_IMAGEM","alteraOrdemBaixob");
defined("EXCLUIR_IMAGEM_GALERIA") || define("EXCLUIR_IMAGEM_GALERIA","alteraOrdemBaixoc");
defined("ALTERAR_POSICAO_IMAGEM") || define("ALTERAR_POSICAO_IMAGEM","alteraOrdemBaixoe");
defined("EXCLUIR_IMAGENS_TEMPORARIAS") || define("EXCLUIR_IMAGENS_TEMPORARIAS","alteraOrdemBaixof");

switch ($opx) {

	case CADASTRO_VANTAGENS:
		include_once 'vantagens_class.php';
		include_once 'includes/fileImage.php';

		$dados = $_REQUEST;
		
        $imagem = $_FILES;

        if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
            $nomeicone = fileImage("vantagens", "", '', $imagem['icone'], 78, 78, 'inside');
            $dados['icone'] = $nomeicone;
        }

		$idVantagens = cadastroVantagens($dados);

		if (is_int($idVantagens)) {  
			 
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'vantagens';
			$log['descricao'] = 'Cadastrou vantagens ID('.$idVantagens.') título ('.$dados['titulo'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') icone ('.$dados['icone'].') ordem ('.$dados['ordem'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=vantagens&acao=listarVantagens&mensagemalerta='.urlencode('Vantagens criado com sucesso!'));
		} else {
			header('Location: index.php?mod=vantagens&acao=listarVantagens&mensagemalerta='.urlencode('ERRO ao criar novo Vantagens!'));
		}

	break;

	case EDIT_VANTAGENS:
		include_once 'vantagens_class.php';
		include_once 'includes/fileImage.php';

		$dados = $_REQUEST;
        $imagem = $_FILES;
        $antigo = buscaVantagens(array('idvantagens'=>$dados['idvantagens']));
		$antigo = $antigo[0]; 

        if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
            $nomeicone = fileImage("vantagens", "", '', $imagem['icone'], 78, 78, 'inside');
            editarImagemVantagens($antigo['icone']);  
            $dados['icone'] = $nomeicone;
        }

		$idVantagens = editVantagens($dados);

		if ($idVantagens != FALSE) { 

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'vantagens';
			$log['descricao'] = 'Editou vantagens ID('.$idVantagens.') DE  título ('.$antigo['titulo'].') texto ('.$antigo['texto'].') imagem ('.$antigo['imagem'].') icone ('.$antigo['icone'].') ordem ('.$antigo['ordem'].') PARA  nome ('.$dados['nome'].') texto ('.$dados['texto'].') imagem ('.$dados['imagem'].') icone ('.$dados['icone'].') ordem ('.$dados['ordem'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=vantagens&acao=listarVantagens&mensagemalerta='.urlencode('Vantagens salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=vantagens&acao=listarVantagens&mensagemalerta='.urlencode('ERRO ao salvar Vantagens!'));
		}

	break;

	case DELETA_VANTAGENS:
		include_once 'vantagens_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('vantagens_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=vantagens&acao=listarVantagens&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaVantagens(array('idvantagens'=>$dados['idu']));

			if (deletaVantagens($dados['idu']) == 1) {
				editarImagemVantagens($antigo[0]['icone']);  
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'vantagens';
				$log['descricao'] = 'Deletou vantagens ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=vantagens&acao=listarVantagens&mensagemalerta='.urlencode('Vantagens deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=vantagens&acao=listarVantagens&mensagemalerta='.urlencode('ERRO ao deletar Vantagens!'));
			}
		}

	break; 

	case LISTAR_VANTAGENS: 

		include_once 'vantagens_class.php';  
        $dados = $_REQUEST;  
        $retorno = array(); 
        $vantagens = buscaVantagens($dados); 
        if(!isset($dados['filtro'])){
	        $retorno['dados'] = $vantagens;
	        $dados['totalRecords'] = true;  
	        $total = buscaVantagens($dados); 
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
            
        include_once('vantagens_class.php');
		include_once 'includes/fileImage.php';
            
		$dados = $_POST;
        $idvantagens = $dados['idvantagens'];
        $posicao = $dados['posicao']; 

        $imagem = $_FILES;
        
        $caminhopasta = "files/vantagens";
        if(!file_exists($caminhopasta)){
        	mkdir($caminhopasta, 0777);
        }  
       
        //galeria grande
      	$nomeimagem = fileImage("vantagens", "", "", $imagem['imagem'], 800, 800, 'inside');
      	$thumb = fileImage("vantagens", $nomeimagem, "thumb", $imagem['imagem'], 102, 102, 'crop');
       
        $caminho = $caminhopasta.'/thumb_'.$nomeimagem;

        //vai cadastrar se já tiver o id do vantagens, senao so fica na pasta.
        $idvantagens_imagem = $nomeimagem; 

        if(is_numeric($idvantagens)){
        	//CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
			$imagem['idvantagens'] = $idvantagens;
			$imagem['descricao_imagem'] = "";
			$imagem['posicao_imagem'] = $posicao;
			$imagem['nome_imagem'] = $nomeimagem; 
			$idvantagens_imagem = salvaImagemVantagens($imagem);	
        } 
       
        print '{"status":true, "caminho":"'.$caminho.'", "idvantagens":"'.$idvantagens.'", "idvantagens_imagem":"'.$idvantagens_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
          
    break; 
 
    case SALVAR_DESCRICAO_IMAGEM:
		include_once('vantagens_class.php');
		$dados = $_POST;

		$imagem = buscaVantagens_imagem(array("idvantagens_imagem"=>$dados['idImagem']));
		$imagem = $imagem[0];
		if($imagem){
			$imagem['descricao_imagem'] = $dados['descricao'];
			if(editVantagens_imagem($imagem)){
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
		include_once('vantagens_class.php');
		$dados = $_POST;  
		$idvantagens = $dados['idvantagens'];
		$idvantagens_imagem = $dados['idvantagens_imagem'];
		$imagem = $dados['imagem'];
		$descricao = $dados['descricao']; 

		$retorno['status'] = apagarImagemVantagens($imagem);
		if(is_numeric($idvantagens) && $idvantagens > 0){ 
			//ESTA EDITANDO OS DADOS, APAGAR IMAGEM DA PASTA E DO BANCO REORDENANDO A POSICAO
			//$retorno['status'] = apagarImagemVantagens($idvantagens, $imagem, $idvantagens_imagem, $descricao); 
			deletarImagemVantagensGaleria($idvantagens_imagem, $idvantagens);
		}  
		print json_encode($retorno); 
	break;

	//ALTERAR POSICAO DA IMAGEM
	case ALTERAR_POSICAO_IMAGEM: 
		include_once('vantagens_class.php');
		$dados = $_POST;  
		alterarPosicaoImagemVantagens($dados);
		print '{"status":true}'; 
	break;

	//EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
	case EXCLUIR_IMAGENS_TEMPORARIAS: 
		include_once('vantagens_class.php');
		$dados = $_POST;	 
		if(isset($dados['imagem_vantagens'])){
			$imgs = $dados['imagem_vantagens'];
			foreach ($imgs as $key => $value) { 
				apagarImagemVantagens($value);
			}
		} 
		print '{"status":true}'; 
	break;

    case PESQUISA_ICONE:
        include_once('vantagens_class.php');
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
		include_once("vantagens_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$vantagens = buscaVantagens(array('idvantagens' => $dados['idvantagens']));
			$vantagens = $vantagens[0];

			$ordem = $vantagens['ordem'] - 1;

			$vantagensAux = buscaVantagens(array('order' => $ordem));

			if (!empty($vantagensAux)) {

				$dadosUpdate = array();
				$dadosUpdate['idvantagens'] = $dados['idvantagens'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemVantagens($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idvantagens'] = $vantagensAux[0]['idvantagens'];
				$dadosUpdate2['ordem'] = intval($vantagens['ordem']);
				editOrdemVantagens($dadosUpdate2);
			}

			print json_encode($resultado);

		} catch (Exception $e) {
			$resultado['status'] = 'falha';
			print json_encode($resultado);
		}
	break;

	case ALTERA_ORDEM_BAIXO:
		include_once("vantagens_class.php");

		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';

		try {

			$vantagens = buscaVantagens(array('idvantagens' => $dados['idvantagens']));
			$vantagens = $vantagens[0];

			$ordem = $vantagens['ordem'] + 1;

			$vantagensAux = buscaVantagens(array('order' => $ordem));

			if (!empty($vantagensAux)) {
				$dadosUpdate = array();
				$dadosUpdate['idvantagens'] = $dados['idvantagens'];
				$dadosUpdate['ordem'] = $ordem;
				editOrdemVantagens($dadosUpdate);

				$dadosUpdate2 = array();
				$dadosUpdate2['idvantagens'] = $vantagensAux[0]['idvantagens'];
				$dadosUpdate2['ordem'] = intval($vantagens['ordem']);
				editOrdemVantagens($dadosUpdate2);
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