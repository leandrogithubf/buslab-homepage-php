<?php
// Versao do modulo: 3.00.010416

include_once "servico_class.php";
$icone = buscaFW(array('ordem' => 'nome', 'dir' => 'asc'));
if (!isset($_REQUEST['acao']))
	$_REQUEST['acao'] = "";
?>
<link rel="stylesheet" type="text/css" href="servico_css.css" />
<script type="text/javascript" src="servico_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if ($_REQUEST['acao'] == "formServico") {
	if ($_REQUEST['met'] == "cadastroServico") {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "servico_script.php?opx=cadastroServico";
		$metodo_titulo = "Cadastro Servico";
		$idServico = 0;

		// dados para os campos
		$servico['nome'] = "";
		$servico['pessoa'] = "";
		$servico['icone'] = "";
		$servico['descricao'] = "";
		$FontAwesome = true;
	} else {
		if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "servico_script.php?opx=editServico";
		$metodo_titulo = "Editar Servico";
		$idServico = (int) $_GET['idu'];
		$servico = buscaServico(array('idservico' => $idServico));
		if (count($servico) != 1) exit;
		$servico = $servico[0];

		$StringIcone = strlen($servico['icone']);
		if ($StringIcone > 3) {
			$FontAwesome = false;
		} else {
			$FontAwesome = true;
			$icones_Edit = buscaFW(array('idfw' => $servico['icone']));
			$icones_Edit = $icones_Edit[0];
		}
	}
?>

	<div id="titulo">
		<img src="images/modulos/servico_preto.png" height="24" width="24" alt="ico" />
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=servico&acao=listarServico">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=servico&acao=formServico&met=cadastroServico">Cadastro</a></li>
		</ul>
	</div>

	<div id="principal">
		<form class="form" name="formServico" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">

			<div id="informacaoServico" class="content">
				<div class="content_tit">Dados Servico:</div>
				<div class="box_ip" style="width: 100%">
					<label for="nome">Nome</label>
					<input type="text" name="nome" id="nome" class="required" size="30" maxlength="100" value="<?php echo $servico['nome']; ?>" />
				</div>
				<div class="box_sel" style="width:48.6%;">
					<label for="">Pessoa</label>
					<div class="box_sel_d">
						<select class="required" name="pessoa" id="pessoa">
							<option disabled>Selecione:</option>
							<option value="F" <?= (($servico['pessoa'] == 'F') ? 'selected="selected"' : ''); ?>> Física </option>
							<option value="J" <?= (($servico['pessoa'] == 'J') ? 'selected="selected"' : ''); ?>> Jurídica </option>
						</select>
					</div>
				</div>

				<!-- ========== Upload Icone ========== -->
				<div class="box_ip" style="width:100%">
					<ul class="tabs">
						<li class="tab-link <?= $FontAwesome ? 'current' : ''; ?>" data-tab="tab-1">Escolher um Ícone</li>
						<li class="tab-link <?= !$FontAwesome ? 'current' : ''; ?>" data-tab="tab-2">Anexar um Ícone</li>
					</ul>
					<div id="tab-1" class="tab-content <?= $FontAwesome ? 'current' : ''; ?>">
						<span class='labeltxt' for="pesquisar_icone" style="margin-bottom:15px"><strong>Ícone</strong></span>
						<?php if ($_GET['met'] == 'editServico') : ?>
							<div id="mostrar_icone" style="margin: 15px">
								<i class='fa fa-<?= $icones_Edit['nome']; ?> fa-2x '></i>
								<input type="hidden" name="icone" value="<?= $FontAwesome ? $icones_Edit['idfw'] : $servico['icone']; ?>" id="imagem_icone">
							</div>
						<?php else : ?>
							<div id="mostrar_icone" style="margin: 15px">
								<input type="hidden" name="icone" id="imagem_icone">
							</div>
						<?php endif; ?>
						<input type="text" name="pesquisar_icone" id="pesquisar_icone" placeholder="Pesquise um icone" style="margin-bottom: 10px">
						<div id="icone_pai">
							<?php foreach ($icone as $key => $i) : ?>
								<div style="width:6%; display: inline-block;" data-toggle="tooltip" title="<?= $i['nome']; ?>">
									<i class="fa fa-<?= $i['nome']; ?> icone_icone" data-id="<?= $i['idfw']; ?>" data-nome="<?= $i['nome']; ?>" style="padding:11px; cursor: pointer;"></i>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div id="tab-2" class="tab-content <?= !$FontAwesome ? 'current' : ''; ?>">
						<?php $caminho = "files/servico/"; ?>
						<div class="content_tit" style="margin-left:0; padding-left:0;">Ícone</div>
						<span class="botaoArquivo" id="inputArquivoBotao">Anexar Ícone <i class="fa fa-paperclip" aria-hidden="true"></i></span>
						<input type="file" name="icone" id="icone_upload" class="all_imagens" data-tipo='1'><br>
						<img class="pump" src="<?= $caminho . $servico['icone']; ?>" height='87' id="icone" style="margin-top: 10px;display: <?= $_GET['met'] == 'editServico' ? (!empty($servico['icone'] && !$FontAwesome) ? 'initial' : 'none') : 'none'; ?>"><br>
						<p class="pre">Tamanho recomendado: 70x62 (ou maior proporcional) - Extensão recomendada: jpg, png</p>
						<span>O arquivo não pode ser maior que:
							<?php
							$tamanho = explode('M', ini_get('upload_max_filesize'));
							$tamanho = $tamanho[0];
							echo $tamanho . 'MB';
							?>
						</span>
						<input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
					</div>
				</div>
				<script>
					var div = document.getElementsByClassName("botaoArquivo")[0];
					var input = document.getElementById("icone_upload");

					div.addEventListener("click", function() {
						input.click();
					});
					input.addEventListener("change", function() {
						var nome = "sem arquivos...";
						if (input.files.length > 0) nome = input.files[0].name;
						div.innerHTML = nome;
					});
				</script>
				<!-- ========== Fim Upload Icone ========== -->

				<div class="box_ip box_txt">
					<label for="descricao">Descricao</label>
					<textarea name="descricao" id="descricao" cols="34" rows="4"><?php echo $servico['descricao']; ?></textarea>
				</div>
			</div>


			<input type="hidden" name="idservico" value="<?php echo $idServico; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" onclick="history.go(-1);" class="bt_cancel cancelar" />
		</form>
	</div>

<?php } ?>



<!--************************************
     _       _        _        _     _
    | |     | |      | |      | |   | |
  __| | __ _| |_ __ _| |_ __ _| |__ | | ___
 / _` |/ _` | __/ _` | __/ _` | '_ \| |/ _ \
| (_| | (_| | || (_| | || (_| | |_) | |  __/
 \__,_|\__,_|\__\__,_|\__\__,_|_.__/|_|\___|
					*******************************-->


<?php if ($_REQUEST['acao'] == "listarServico") { ?><?php
													if (!verificaPermissaoAcesso($MODULOACESSO['modulo'] . '_visualizar', $MODULOACESSO['usuario']))
														header('Location:index.php?mod=home&mensagemalerta=' . urlencode('Voce nao tem privilegios para acessar este modulo!'));
													?>
<div id="titulo">
	<img src="images/modulos/servico_preto.png" height="22" width="24" alt="ico" />
	<span>Listagem de Servico</span>
	<ul class="other_abs">
		<li class="other_abs_li"><a href="index.php?mod=servico&acao=listarServico">Listagem</a></li>
		<li class="others_abs_br"></li>
		<li class="other_abs_li"><a href="index.php?mod=servico&acao=formServico&met=cadastroServico">Cadastro</a></li>
	</ul>
</div>
<div class="search">
	<form name="formbusca" method="post" action="#" onsubmit="return false">
		<input type="text" name="buscarapida" value="Buscar" onblur="campoBuscaEscreve(this);" onfocus="campoBuscaLimpa(this);" id="buscarapida" />
	</form>
	<a href="" class="search_bt">Busca Avançada</a>
</div>
<div class="advanced">
	<form name="formAvancado" id="formAvancado" method="post" action="#" onsubmit="return false">
		<p class="advanced_tit">Busca Avançada</p>
		<img class="advanced_close" src="images/ico_close.png" height="10" width="11" alt="ico" />
		<div class="box_ip"><label for="adv_nome">Nome</label><input type="text" name="nome" id="adv_nome"></div>
		<div class="box_ip"><label for="adv_pessoa">Pessoa</label><input type="text" name="pessoa" id="adv_pessoa"></div>
		<div class="box_ip"><label for="adv_icone">Icone</label><input type="text" name="icone" id="adv_icone"></div>
		<div class="box_ip"><label for="adv_descricao">Descricao</label><input type="text" name="descricao" id="adv_descricao"></div>
		<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
	</form>
</div>




<div id="principal">
	<div id="abas">
		<ul class="abas_list">
			<li class="abas_list_li action"><a href="javascript:void(0)">Servico</a></li>
		</ul>
		<ul class="abas_bts">
			<li class="abas_bts_li"><a href="index.php?mod=servico&acao=formServico&met=cadastroServico"><img src="images/novo.png" alt="Cadastro Servico" title="Cadastrar Servico" /></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=servico&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
			<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=servico&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"></a></li>
		</ul>
	</div>
	<table class="table" cellspacing="0" cellpadding="0" id="listagem">
		<thead>
		</thead>
		<tbody>
		</tbody>
	</table>
	<?php include_once("paginacao/paginacao.php"); ?>




	<?php
	$dados = isset($_POST) ? $_POST : array();
	$buscar = '';
	foreach ($dados as $k => $v) {
		if (!empty($v))
			$buscar .= $k . '=' . $v . '&';
	}
	?>


	<script type="text/javascript">
		queryDataTable = '<?php print $buscar; ?>';
		requestInicio = "tipoMod=servico&p=" + preventCache + "&";
		ordem = "idservico";
		dir = "desc";
		$(document).ready(function() {
			preTableServico();
		});
		dataTableServico('<?php print $buscar; ?>');
		columnServico();
	</script>




</div>

<?php } ?>