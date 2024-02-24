<?php 
	 // Versao do modulo: 3.00.010416

	include_once "servicos_class.php";
	include_once "includes/functions.php";
	include_once "idiomas_class.php";
	$idiomas = buscaIdiomas(array('status'=>'1'));
    $icone = buscaFW3(array('ordem' => 'nome', 'dir' => 'asc'));

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";
?>
<link rel="stylesheet" type="text/css" href="servicos_css.css" />
<script type="text/javascript" src="servicos_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formServicos"){
	if($_REQUEST['met'] == "cadastroServicos"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "servicos_script.php?opx=cadastroServicos";
		$metodo_titulo = "Cadastro Serviços";
		$idServicos = 0 ;

		// dados para os campos
		$servicos['titulo'] = '';
		$servicos['resumo'] = '';
		$servicos['descricao'] = '';
		$servicos['ididiomas'] = '';
		$servicos['icone'] = '';
		$FontAwesome = false;
	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "servicos_script.php?opx=editServicos";
		$metodo_titulo = "Editar Serviços";
		$idServicos = (int) $_GET['idu'];
		$servicos = buscaServicos(array('idservicos'=>$idServicos));
		$recursos = buscaRecursos(array('idservicos'=>$idServicos));
		if (count($servicos) != 1) exit;
		$servicos = $servicos[0];

		$StringIcone = strlen($servicos['icone']);
        if ($StringIcone > 3) {
            $FontAwesome = false;
        } else {
            $FontAwesome = true;
            $icones_Edit2 = buscaFW3(array('idfw' => $servicos['icone']));
            $icones_Edit2 = $icones_Edit2[0];
        }
	}
?>

	<div id="titulo">
		<!-- <img src="images/modulos/servicos_preto.png" height="24" width="24" alt="ico" /> -->
		<i class="fa fa-bars fa-2x"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=servicos&acao=listarServicos">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=servicos&acao=formServicos&met=cadastroServicos">Cadastro</a></li> 
		</ul>
	</div>

	<div id="principal">
		<form class="form" id="formServicos" name="formServicos" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" onsubmit="return verificarCampos(new Array('titulo_aba', 'resumo', 'descricao', 'ididiomas')); " >

			<div id="informacaoServicos" class="content">
				<div class="content_tit">Dados Serviços:</div>
				<!-- ========== Upload Icone ========== -->
                    <div class="box_ip" style="width:100%">
                        <ul class="tabs">
                            <li class="tab-link <?= $FontAwesome ? 'current' : ''; ?>" data-tab="tab-1">Escolher um Ícone</li>
                            <li class="tab-link <?= !$FontAwesome ? 'current' : ''; ?>" data-tab="tab-2">Anexar um Ícone</li>
                        </ul>
                        <div id="tab-1" class="tab-content <?= $FontAwesome ? 'current' : ''; ?>">
                            <span id="icone-titulo" class='labeltxt' for="pesquisar_icone" style="margin-bottom:15px"><strong>Ícone</strong></span>
                            <?php if ($_GET['met'] == 'editServicos') : ?>
                                <div id="mostrar_icone2" style="margin: 15px">
                                    <i class='fa fa-<?= $icones_Edit2['nome']; ?> fa-2x '></i>
                                    <input type="hidden" name="icone2" value="<?= $FontAwesome ? $icones_Edit2['idfw'] : $servicos['icone']; ?>" id="imagem_icone">
                                </div>
                            <?php else : ?>
                                <div id="mostrar_icone2" style="margin: 15px">
                                    <input type="hidden" name="icone2" id="imagem_icone">
                                </div>
                            <?php endif; ?>
                            <input type="text" name="pesquisar_icone" id="pesquisar_icone" placeholder="Pesquise um icone" style="margin-bottom: 10px">
                            <div id="icone_pai">
                                <?php foreach ($icone as $key => $i) : ?>
                                    <div style="width:6%; display: inline-block;" data-toggle="tooltip" title="<?= $i['nome']; ?>">
                                        <i class="fa fa-<?= $i['nome']; ?> icone_icone2" data-id="<?= $i['idfw']; ?>" data-nome="<?= $i['nome']; ?>" style="padding:11px; cursor: pointer;"></i>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-content <?= !$FontAwesome ? 'current' : ''; ?>">
                            <?php $caminho = "files/servicos/"; ?>
                            <div class="content_tit" style="margin-left:0; padding-left:0;">Ícone Positivo</div>
                            <span class="botaoArquivo" id="inputArquivoBotao">Anexar Ícone Postivo<i class="fa fa-paperclip" aria-hidden="true"></i></span>
                            <input type="file" name="icone2" id="icone_upload" class="all_imagens" data-tipo='1'><br>
                            <input type="hidden" id="imagem_value">
                            <img class="pump" src="<?= $caminho . $servicos['icone']; ?>" height='87' id="icone" style="margin-top: 10px;display: <?= $_GET['met'] == 'editServicos' ? (!empty($servicos['icone'] && !$FontAwesome) ? 'initial' : 'none') : 'none'; ?>"><br>

                            <div class="content_tit" style="margin-left:0; padding-left:0;">Ícone Negativo</div>
                            <span class="botaoArquivo2" id="inputArquivoBotao2">Anexar Ícone Negativo<i class="fa fa-paperclip" aria-hidden="true"></i></span>
                            <input type="file" name="icone3" id="icone_upload2" class="all_imagens" data-tipo='1'><br>
                            <input type="hidden" id="imagem_value2">
                            <img class="pump" src="<?= $caminho .'negativo_'. $servicos['icone']; ?>" height='87' id="icone2" style="margin-top: 10px;display: <?= $_GET['met'] == 'editServicos' ? (!empty($servicos['icone'] && !$FontAwesome) ? 'initial' : 'none') : 'none'; ?>"><br>

                            <p class="pre">Tamanho recomendado: 60x60 (ou maior proporcional) - Extensão recomendada: jpg, png</p>
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
                        var div2 = document.getElementsByClassName("botaoArquivo2")[0];
                        var input = document.getElementById("icone_upload");
                        var input2 = document.getElementById("icone_upload2");

                        var imagem_value = document.getElementById("imagem_value");
                        var imagem_value2 = document.getElementById("imagem_value2");

                        div.addEventListener("click", function() {
                            input.click();
                        });
                        div2.addEventListener("click", function() {
                            input2.click();
                        });
                        input.addEventListener("change", function() {
                            var nome = "sem arquivos...";
                            if (input.files.length > 0) nome = input.files[0].name;
                            div.innerHTML = nome;
                            imagem_value.value = nome;
                        });
                        input2.addEventListener("change", function() {
                            var nome2 = "sem arquivos...";
                            if (input2.files.length > 0) nome2 = input2.files[0].name;
                            div2.innerHTML = nome2;
                            imagem_value2.value = nome2;
                        });
                    </script>
                    <!-- ========== Fim Upload Icone ========== -->
					<div class="box_ip">
						<label for="titulo_aba">Nome</label>
						<input type="text" name="titulo" id="titulo_aba" class='required' size="30" value="<?php echo $servicos['titulo']; ?>" />
					</div>
					<div class="box_ip">
	                    <label  for="ididiomas">Idioma</label>
	                    <div class="box_sel" style='width:100%;margin:0;'>
	                        <label for="">Idioma</label>
	                        <div class="box_sel_d" style='width:99%;'>
	                            <select name="ididiomas" id="ididiomas" class='required'>
	                                <?php foreach($idiomas as $key => $idioma):?>
	                                    <option value="<?=$idioma['ididiomas']?>" <?php print ($servicos['ididiomas'] == $idioma['ididiomas'] ? ' selected="selected" ' : ''); ?> > <?=$idioma['idioma']?> </option>
	                                <?php endforeach;?>
	                            </select>
	                        </div>
	                   </div>
	                </div>
					<div class="box_ip box_txt">
						<label for="resumo">Descrição Inicial</label>
						<textarea name="resumo" id="resumo" class="required" size="30"><?php echo $servicos['resumo']; ?></textarea>
					</div>
					<div class="box_ip box_txt">
						<label for="descricao">Descrição Secundária</label>
						<textarea name="descricao" id="descricao" class="required" value='' size="30"><?php echo $servicos['descricao']; ?></textarea>
					</div>
                    <!-- =======================Recursos========================== -->

                    <div class="listaRecursos" style="float: left; width: 100%">
	                    <div class="content_tit">
	                        <label>Diferenciais</label><br/>
	                        <a href="javascript:;" class="btn btn-recursos"><i class="fa fa-plus"></i> Adicionar</a>
	                    </div>
	                    <div class="gridLista" id="gridRecursos">
	                        <table class="table" id="tableRecursos">
	                            <thead>
	                            <tr>
	                                <th align="center" style="width: 20%;">Imagem/Ícone</th>
	                                <th style="text-align: left;width: 30%;" class=""></th>
	                                <th style="text-align: left;width: 40%;" class=""></th>
	                                <th style="width: 10%;">&nbsp;</th>
	                                <th style="width: 10%;">Ordem</th>
	                            </tr>
	                            </thead>
	                            <tbody class="recursos">
	                            <?php if(isset($recursos) && !empty($recursos)):?>
	                                <?php foreach($recursos as $key => $rec):
			                            $icones_Edit = buscaFW3(array('idfw' => $rec['icone']));
		            					$icones_Edit = $icones_Edit[0];?>

	                                    <tr class="box-recursos removeRecursos-<?=$key;?>">
	                                        <td align="center" class="td-padding">
                                                <?php if(empty($rec['imagem'])):?>
                                                   <img src="https://via.placeholder.com/100?text=Upload+Foto" width="100"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php else:?>
	                                               <img src="files/recursos/<?=$rec['imagem'];?>" width="100"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php endif;?>
	                                            <input type="file" name="recursos[<?=$key;?>][imagem]" class="file-upload upload-<?=$key;?>" data-key="<?=$key;?>" style="display:none">
	                                            <span style="font-size:11px">Tamanho recomendado 70x70 </span>
	                                            <input type="hidden" name="recursos[<?=$key;?>][imagem]" value="<?=$rec['imagem'];?>">

									            <div id="mostrar_icone-<?=$key;?>" style="margin: 15px">
									                <i class='fa fa-<?=$icones_Edit['nome'];?> fa-2x '></i>
									                <input type="hidden" name="recursos[<?=$key;?>][icone]" value="<?=$rec['icone'];?>" id="imagem_icone-<?=$key;?>">
									            </div>

	                                            <input type="button" value="Escolher ícone" class="btn button-escolher-icone" data-key="<?=$key;?>">

	                                            <input type="hidden" name="recursos[<?=$key;?>][idrecursos]" value="<?=$rec['idrecursos'];?>">
	                                            <input id='excluirRecurso-<?=$key;?>' type="hidden" name="recursos[<?=$key;?>][excluirRecurso]" value="1">
	                                        </td>
	                                        <td colspan="2">
	                                            <input type="text" class="box_txt inputRecursos w-100" name="recursos[<?=$key;?>][nome]" value="<?=$rec['nome'];?>" placeholder="Nome">
	                                            <!-- <textarea rows="6" type="text" style="resize: vertical" class="box_txt inputRecursos w-100" name="recursos[<?=$key;?>][descricao]" placeholder="Descrição"><?=$rec['descricao'];?></textarea> -->
	                                        </td>
	                                        <td align="center">
	                                            <span class="excluirRecursos" data-key="<?=$key;?>">
	                                                <b class="fa fa-trash ico-del"></b>
	                                            </span>
	                                        </td>
	                                        <td align="center">
	                                            <span><img src="images/arrUp.png" codigo="<?=$rec['idrecursos'];?>" class="link ordemUpRec"></span>
	                                            <hr style="margin-bottom: 20px;margin-top: 20px;">
	                                            <span><img src="images/arrDown.png" codigo="<?=$rec['idrecursos'];?>" class="link ordemDownRec"></span>
	                                    		<!-- <input style="margin-top:25%;" id="ordem<?=$rec['idrecursos'];?>" class="inputRecursos" type="text" disabled value="<?=$rec['ordem']?>"> -->
	                                        </td>
	                                    </tr>

	                                    <tr>
	                                    	<td colspan="4">
	                                    		<div id="escolha-icone-<?=$key;?>"><div class="box_ip div-icones" style="width: 100% !important;"></div></div>
	                                    	</td>
	                                    </tr>

	                                <?php endforeach;?>
	                            <?php endif;?>
	                            </tbody>
	                        </table>
	                    </div>
	                </div>

	                <div class="div-mostra-icones div-icones">
				        <input type="text" name="pesquisar_icone" class="pesquisar_icone" placeholder="Pesquise um icone" style="margin-bottom: 10px;">
				        <div class="icone_pai">
				            <?php foreach ($icone as $key => $i) : ?>
				                <div style="width:6%; display: inline-block;" data-toggle="tooltip" title="<?= $i['nome']; ?>">
				                    <i class="fa fa-<?= $i['nome']; ?> icone_icone" data-id="<?= $i['idfw']; ?>" data-nome="<?= $i['nome']; ?>" style="padding:11px; cursor: pointer;"></i>
				                </div>
				            <?php endforeach; ?>
				        </div>
				    </div>

				    <!-- =======================Fim Recursos========================== -->
			</div>

			<input type="hidden" name="thumbs" id="thumbs_old" size="30" value="<?php echo $servicos['thumbs']; ?>" />
			<input type="hidden" name="banner_topo" id="banner_topo_old" size="30" value="<?php echo $servicos['banner_topo']; ?>" />
			<input type="hidden" id="mod" name="mod" value="<?= ($idServicos == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" id="idservicos" name="idservicos" value="<?php echo $idServicos; ?>" />
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


<?php if($_REQUEST['acao'] == "listarServicos"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	<div id="titulo">
		<!-- <img src="images/modulos/servicos_preto.png" height="22" width="24" alt="ico" /> -->
		<i class="fa fa-bars fa-2x"></i>
		<span>Listagem de Serviços</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=servicos&acao=listarServicos">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=servicos&acao=formServicos&met=cadastroServicos">Cadastro</a></li>
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
			<div class="box_ip"><label for="adv_titulo_aba">Título</label><input type="text" name="titulo" id="adv_titulo_aba"></div>
			<div class="box_ip"><label for="adv_slogan_faq">Slogan</label><input type="text" name="slogan_faq" id="adv_slogan_faq"></div>
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>

	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Serviços</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=servicos&acao=formServicos&met=cadastroServicos"><img src="images/novo.png" alt="Cadastro Servicos" title="Cadastrar Servicos" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=servicos&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=servicos&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			foreach($dados as $k=>$v){
				if(!empty($v))
					$buscar .= $k.'='.$v.'&';
			}
		?>


		<script type="text/javascript">
			queryDataTable = '<?php print $buscar; ?>';
			requestInicio = "tipoMod=servicos&p="+preventCache+"&";
			ordem = "ordem";
			dir = "asc";
			$(document).ready(function(){
				preTableServicos();
			});
			dataTableServicos('<?php print $buscar; ?>');
			columnServicos();
		</script>




	</div>

<?php } ?>

