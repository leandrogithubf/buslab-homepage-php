<?php 
	 // Versao do modulo: 3.00.010416

require_once 'includes/verifica.php'; // checa user logado

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_SERVICO") || define("CADASTRO_SERVICO","cadastroServico");
defined("PESQUISA_ICONE") || define("PESQUISA_ICONE", "pesquisaIcone");
defined("PESQUISA_ICONE_SERVICOS") || define("PESQUISA_ICONE_SERVICOS", "pesquisaIconeServicos");
defined("PESQUISA_ICONE_IMAGEM") || define("PESQUISA_ICONE_IMAGEM", "pesquisaIconeImagem");
defined("EDIT_SERVICO") || define("EDIT_SERVICO","editServico");
defined("DELETA_SERVICO") || define("DELETA_SERVICO","deletaServico");

switch ($opx) {

	case CADASTRO_SERVICO:
		include_once 'servico_class.php';
		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php';

		$dados = $_REQUEST;
		$imagem = $_FILES;

		if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
			$nomeicone = fileImage("servico", "", '', $imagem['icone'], 32, 32, 'inside');
			$dados['icone'] = $nomeicone;
		}
		
		$dados['nome'] = ltrim($dados['nome']);

		$idServico = cadastroServico($dados);

		if (is_int($idServico)) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'servico';
			$log['descricao'] = 'Cadastrou servico ID('.$idServico.') nome ('.$dados['nome'].') pessoa ('.$dados['pessoa'].') icone ('.$dados['icone'].') descricao ('.$dados['descricao'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=servico&acao=listarServico&mensagemalerta='.urlencode('Servico criado com sucesso!'));
		} else {
			header('Location: index.php?mod=servico&acao=listarServico&mensagemalerta='.urlencode('ERRO ao criar novo Servico!'));
		}

	break;

	case EDIT_SERVICO:
		include_once 'servico_class.php';
		include_once 'includes/fileImage.php';
		include_once 'includes/functions.php';

		$dados = $_REQUEST;
		$antigo = buscaServico(array('idservico'=>$dados['idservico']));
		$antigo = $antigo[0];

		$dados['nome'] = ltrim($dados['nome']);

		$imagem = $_FILES;
			
		if (isset($_FILES['icone']) && $_FILES['icone']['error'] == 0) {
			$nomeicone = fileImage("servico", "", '', $imagem['icone'], 32, 32, 'inside');
			$dados['icone'] = $nomeicone;
		}

		$idServico = editServico($dados);

		if ($idServico != FALSE) {
			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'servico';
			$log['descricao'] = 'Editou servico ID('.$idServico.') DE  nome ('.$antigo['nome'].') pessoa ('.$antigo['pessoa'].') icone ('.$antigo['icone'].') descricao ('.$antigo['descricao'].') PARA  nome ('.$dados['nome'].') pessoa ('.$dados['pessoa'].') icone ('.$dados['icone'].') descricao ('.$dados['descricao'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=servico&acao=listarServico&mensagemalerta='.urlencode('Servico salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=servico&acao=listarServico&mensagemalerta='.urlencode('ERRO ao salvar Servico!'));
		}

	break;

	case DELETA_SERVICO:
		include_once 'servico_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('servico_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=servico&acao=listarServico&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaServico(array('idservico'=>$dados['idu']));

			if (deletaServico($dados['idu']) == 1) {
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'servico';
				$log['descricao'] = 'Deletou servico ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=servico&acao=listarServico&mensagemalerta='.urlencode('Servico deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=servico&acao=listarServico&mensagemalerta='.urlencode('ERRO ao deletar Servico!'));
			}
		}

	break;

	case PESQUISA_ICONE:
		include_once('servico_class.php');
		$dados = $_REQUEST;
		$icone = buscaFW(array('nome' => $dados['nome'], 'ordem' => 'nome', 'dir' => 'asc'));
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

   case PESQUISA_ICONE_SERVICOS:
      include_once('servico_class.php');
      $dados = $_REQUEST;
      $icone = buscaFW(array('nome' => $dados['nome'], 'ordem' => 'nome', 'dir' => 'asc'));
      if (!empty($icone)) {
         $html = '';
         foreach ($icone as $key => $i) {
            $html .= '<div style="width:6%; display: inline-block;" data-id="' . $i['idfw'] . '" data-toggle="tooltip" title="' . $i['nome'] . '">';
            $html .= '    <i class="fa fa-' . $i['nome'] . ' icone_icone-servicos" data-id="' . $i['idfw'] . '" data-nome="' . $i['nome'] . '" style="padding:11px; cursor: pointer;"></i>';
            $html .= '</div>';
         }
      } else {
         $html = '<span>Nenhum icone encontrado</span>';
      }
      echo $html;

   break;

   case PESQUISA_ICONE_IMAGEM:
      include_once('servico_class.php');
      $dados = $_REQUEST;
      $icone = buscaFW(array('nome' => $dados['nome'], 'ordem' => 'nome', 'dir' => 'asc'));
      if (!empty($icone)) {
         $html = '';
         foreach ($icone as $key => $i) {
            $html .= '<div style="width:6%; display: inline-block;" data-id="' . $i['idfw'] . '" data-toggle="tooltip" title="' . $i['nome'] . '">';
            $html .= '    <i class="fa fa-' . $i['nome'] . ' icone_icone-imagem" data-id="' . $i['idfw'] . '" data-nome="' . $i['nome'] . '" style="padding:11px; cursor: pointer;"></i>';
            $html .= '</div>';
         }
      } else {
         $html = '<span>Nenhum icone encontrado</span>';
      }
      echo $html;

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