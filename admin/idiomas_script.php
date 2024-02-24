<?php 
// @session_start();
 
if($_REQUEST["opx"] != "retornaMensagem"){ 
	require_once 'includes/verifica.php'; // checa user logado
} 

$opx = $_REQUEST["opx"];

defined("CADASTRO_IDIOMAS") || define("CADASTRO_IDIOMAS","cadastroIdiomas");
defined("EDIT_IDIOMAS") || define("EDIT_IDIOMAS","editIdiomas");
defined("DELETA_IDIOMAS") || define("DELETA_IDIOMAS","deletaIdiomas");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE","verificarUrlRewrite");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
defined("RETORNA_MENSAGEM") || define("RETORNA_MENSAGEM","retornaMensagem");

switch ($opx) {

	case CADASTRO_IDIOMAS:
		include_once 'idiomas_class.php';

		$dados = $_REQUEST;
		$idtemporario = $dados['ididiomas'];
		$idIdiomas = cadastroIdiomas($dados);

		if (is_int($idIdiomas)) {

			if(!is_numeric($idtemporario) && file_exists('files/idiomas/'.$idtemporario.'/')){
				rename('files/idiomas', 'files/idiomas');
			} 

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'idiomas';
			$log['descricao'] = 'Cadastrou idiomas ID('.$idIdiomas.') idioma ('.$dados['idioma'].') bandeira ('.$dados['bandeira'].') urlamigavel ('.$dados['urlamigavel'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=idiomas&acao=listarIdiomas&mensagemalerta='.urlencode('Idiomas criado com sucesso!'));
		} else {
			header('Location: index.php?mod=idiomas&acao=listarIdiomas&mensagemalerta='.urlencode('ERRO ao criar novo Idiomas!'));
		}

	break;

	case EDIT_IDIOMAS:
		include_once 'idiomas_class.php';

		$dados = $_REQUEST;
		$antigo = buscaIdiomas(array('ididiomas'=>$dados['ididiomas']));
		$antigo = $antigo[0];

		$idIdiomas = editIdiomas($dados);

		if ($idIdiomas != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'idiomas';
			$log['descricao'] = 'Editou idiomas ID('.$idIdiomas.') DE  idioma ('.$antigo['idioma'].') bandeira ('.$antigo['bandeira'].') urlamigavel ('.$antigo['urlamigavel'].') status ('.$antigo['status'].') PARA  idioma ('.$dados['idioma'].') bandeira ('.$dados['bandeira'].') urlamigavel ('.$dados['urlamigavel'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=idiomas&acao=listarIdiomas&mensagemalerta='.urlencode('Idiomas salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=idiomas&acao=listarIdiomas&mensagemalerta='.urlencode('ERRO ao salvar Idiomas!'));
		}

	break;

	case DELETA_IDIOMAS:
		include_once 'idiomas_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('idiomas_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=idiomas&acao=listarIdiomas&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaIdiomas(array('ididiomas'=>$dados['idu']));

			if (deletaIdiomas($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'idiomas';
				$log['descricao'] = 'Deletou idiomas ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=idiomas&acao=listarIdiomas&mensagemalerta='.urlencode('Idiomas deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=idiomas&acao=listarIdiomas&mensagemalerta='.urlencode('ERRO ao deletar Idiomas!'));
			}
		}

	break;

	//SALVA ICONE DO SERVICO
    case SALVA_IMAGEM:
            
        include_once('idiomas_class.php'); 
		require_once 'includes/fileImage.php';
                
		$dados = $_POST; 
        $ididiomas = $dados['ididiomas'];  
        	
        $imagem = $_FILES;
        if(empty($ididiomas)){
           $ididiomas = md5(uniqid(rand(), true));
        } 
        
        $image = fileImage("idiomas", "", "", $imagem['imagem'], 24, 24, 'inside');
 
        $caminho = 'files/idiomas/'.$image; 
        
        if(file_exists($caminho)){   
        	//apaga os arquivos anteriores que foram salvos 
     		if(!empty($pasta)){
		 		$apagaImg = deletaImagemIdiomas($ididiomas, $image,"","","","");  	
		  	}
			if(is_numeric($ididiomas)){
				//edita o nome do idiomas, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
				$idiomas = buscaIdiomas(array("ididiomas"=>$ididiomas));
				if(!empty($idiomas)){
					$idiomas = $idiomas[0]; 
					$edita = editIdiomas($idiomas);
				}
			} 
            echo '{"status":true, "caminho":"'.$caminho.'", "ididiomas":"'.$ididiomas.'", "nome_arquivo":"'.$image.'"}'; 
        }else{
            echo '{"status":false, "ididiomas":"'.$ididiomas.'", "msg":"erro ao salvar a imagem. Tente novamente"}'; 
        }
        
    break;

    case VERIFICAR_URLREWRITE:

		include_once('idiomas_class.php'); 
		include_once('includes/functions.php');

		$dados = $_POST;
		$dados['urlamigavel'] = str_replace("-"," ",$dados['urlamigavel']);
		$urlrewrite = converteUrl(utf8_encode($dados['urlamigavel']));
		
 		if(!isset($dados['ididiomas']) || $dados['ididiomas'] <= 0){
 			$url = buscaIdiomas(array("urlamigavel"=>$urlrewrite));
 		}else{
 			$url = buscaIdiomas(array("urlamigavel"=>$urlrewrite,"not_ididiomas"=>$dados['ididiomas']));
 		}

 		if(empty($url)){ 
 			print '{"status":true,"url":"'.$urlrewrite.'"}'; 			 
 		}else{
 			print '{"status":false}';
 		}

	break;

	case RETORNA_MENSAGEM:
		include_once('idiomas_traducao_class.php');

		$dados = $_REQUEST; 

		$msg = traduzir($dados['ididioma'], $dados['tag']);
		$msg2 = "";
		if(isset($dados['tag2'])){
			$msg2 = traduzir($dados['ididioma'], $dados['tag2']);
		} 
		
		if(isset($dados['buttons_logout'])){
			$retorno['btn_sair'] = traduzir($dados['ididioma'], 'btn_sair');
			$retorno['btn_cancelar'] = traduzir($dados['ididioma'], 'tag_btn_cancelar');
			print '{"tag":"'.$msg.'","tag2":"'.$msg2.'", "buttons":'.json_encode($retorno).'}';
		}else if(isset($dados['buttons_excluir'])){
			$retorno['btn_excluir'] = traduzir($dados['ididioma'], 'tag_btn_excluir');
			$retorno['btn_cancelar'] = traduzir($dados['ididioma'], 'tag_btn_cancelar');
			
			print '{"tag":"'.$msg.'","tag2":"'.$msg2.'", "buttons":'.json_encode($retorno).'}';
		}else{
			print '{"tag":"'.$msg.'","tag2":"'.$msg2.'"}';
		}

	break;

	case INVERTE_STATUS:
		include_once("idiomas_class.php");
		$dados = $_REQUEST;
		$resultado['status'] = 'sucesso';
		include_once("includes/functions.php");
		$tabela = 'idiomas';
		$id = 'ididiomas';

		try {
			$idiomas = buscaIdiomas(array('ididiomas' => $dados['ididiomas']));
			$idiomas = $idiomas[0];

			// print_r($idiomas);
			if($idiomas['status'] == 1){
				$status = 0;
			}
			else{
				$status = 1;
			}

			$dadosUpdate = array();
			$dadosUpdate['ididiomas'] = $dados['ididiomas'];
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