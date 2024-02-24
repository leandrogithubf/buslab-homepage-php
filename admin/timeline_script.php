<?php 
	 // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("INVERTE_STATUS") || define("INVERTE_STATUS", "inverteStatus");
defined("CADASTRO_TIMELINE") || define("CADASTRO_TIMELINE","cadastroTimeline");
defined("EDIT_TIMELINE") || define("EDIT_TIMELINE","editTimeline");
defined("DELETA_TIMELINE") || define("DELETA_TIMELINE","deletaTimeline");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");

switch ($opx) {

	case CADASTRO_TIMELINE:
		include_once 'timeline_class.php';

		$dados = $_REQUEST;

		$idTimeline = cadastroTimeline($dados);

		if (is_int($idTimeline)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'timeline';
			$log['avaliacao'] = 'Cadastrou timeline ID('.$idTimeline.') titulo ('.$dados['titulo'].') imagem ('.$dados['imagem'].') status ('.$dados['status'].') data ('.$dados['data'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=timeline&acao=listarTimeline&mensagemalerta='.urlencode('Timeline criado com sucesso!'));
		} else {
			header('Location: index.php?mod=timeline&acao=listarTimeline&mensagemalerta='.urlencode('ERRO ao criar novo Timeline!'));
		}

		break;

	case EDIT_TIMELINE:
		include_once 'timeline_class.php';

		$dados = $_REQUEST;
		$antigo = buscaTimeline(array('idtimeline'=>$dados['idtimeline']));
		$antigo = $antigo[0];

		$idTimeline = editTimeline($dados);

		if ($idTimeline != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'timeline';
			$log['avaliacao'] = 'Editou timeline ID('.$idTimeline.') DE  titulo ('.$antigo['titulo'].')imagem ('.$antigo['imagem'].') status ('.$antigo['status'].') data ('.$dados['data'].') PARA  titulo ('.$dados['titulo'].') imagem ('.$dados['imagem'].') status ('.$dados['status'].') data ('.$dados['data'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=timeline&acao=listarTimeline&mensagemalerta='.urlencode('Timeline salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=timeline&acao=listarTimeline&mensagemalerta='.urlencode('ERRO ao salvar Timeline!'));
		}

		break;

	case DELETA_TIMELINE:
		include_once 'timeline_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('timeline_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=timeline&acao=listarTimeline&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaTimeline(array('idtimeline'=>$dados['idu']));
			// apagarImagemTimeline($antigo[0]['imagem']);

			if (deletaTimeline($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'timeline';
				$log['avaliacao'] = 'Deletou timeline ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=timeline&acao=listarTimeline&mensagemalerta='.urlencode('Timeline deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=timeline&acao=listarTimeline&mensagemalerta='.urlencode('ERRO ao deletar Timeline!'));
			}
		}

	break;

	case SALVA_IMAGEM:
		include_once('timeline_class.php');
        include_once 'includes/fileImage.php';

        $dados = $_POST;

        $idtimeline = $dados['idtimeline'];
        if(array_key_exists('imagem_old', $dados)){
            $imgAntigo = $dados['imagem_old'];
        }

        $imagem = $_FILES;

        $antigo = array();
        if(!empty($idplataforma) &&  $idplataforma > 0){
            $antigo = buscaTimeline(array('idtimeline'=>$idtimeline));
            $antigo = $antigo[0];
        }

        $width = 163;
        $height = 163;

        //imagem
        $nomeimagem = fileImage("timeline", "", "", $imagem['imagem'], $width, $height, 'resize');
        // $nomeimagem = fileImage("timeline", $nomeimage, "", $imagem['imagem'], $width, $height, 'crop');

        $caminho = 'files/timeline/'.$nomeimagem;

        if(file_exists($caminho)){
            //apaga os arquivos anteriores que foram salvos
            if(!empty($imgAntigo)){
                $apgImage = apagarImagemTimeline($imgAntigo);
            }
            if(is_numeric($idtimeline) && $idtimeline > 0){
                //edita o nome do banner, pois se alterar e cancelar - ja trocou a imagem. // para evitar de ficar sem imagem
                $timeline = $antigo;
                if(array_key_exists('imagem_old', $dados)){
                    $timeline['imagem'] = $nomeimagem;
                }
            }
            echo '{"status":true, "caminho":"'.$caminho.'", "idtimeline":"'.$idtimeline.'", "nome_arquivo":"'.$nomeimagem.'"}';
        }else{
            echo '{"status":false, "idtimeline":"'.$idtimeline.'", "msg":"erro ao salvar a imagem. Tente novamente"}';
        }
	break;

	case INVERTE_STATUS:
		include_once("timeline_class.php");
		include_once("includes/functions.php");
		$dados = $_REQUEST;
		// inverteStatus($dados);
		$resultado['status'] = 'sucesso';

		$tabela = 'timeline';
		$id = 'idtimeline';

		try {
			$timeline = buscaTimeline(array('idtimeline' => $dados['idtimeline']));
			$timeline = $timeline[0];

			// print_r($depoimento);
			if($timeline['status'] == 1){
				$status = 0;
			}
			else{
				$status = 1;
			}

			$dadosUpdate = array();
			$dadosUpdate['idtimeline'] = $dados['idtimeline'];
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