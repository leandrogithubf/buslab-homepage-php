<?php 
	 // Versao do modulo: 3.00.010416

	include_once "timeline_class.php";
   include_once "idiomas_class.php";

    $idiomas = buscaIdiomas(array('status'=>'1'));

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";
?>
<link rel="stylesheet" type="text/css" href="timeline_css.css" />
<script type="text/javascript" src="timeline_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formTimeline"){
	if($_REQUEST['met'] == "cadastroTimeline"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "timeline_script.php?opx=cadastroTimeline";
		$metodo_titulo = "Cadastro Timeline";
		$idTimeline = 0 ;

		// dados para os campos
		$timeline['titulo'] = "";
		$timeline['imagem'] = "";
		$timeline['status'] = "";
		$timeline['ano'] = "";
      $timeline['texto'] = "";
      $timeline['ididiomas'] = "";
	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "timeline_script.php?opx=editTimeline";
		$metodo_titulo = "Editar Timeline";
		$idTimeline = (int) $_GET['idu'];
		$timeline = buscaTimeline(array('idtimeline'=>$idTimeline));
		if (count($timeline) != 1) exit;
		$timeline = $timeline[0];
	}
?>

	<div id="titulo">
		<!-- <img src="images/modulos/timeline_preto.png" height="24" width="24" alt="ico" /> -->
		<i class="fa fa-bars fa-2x"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=timeline&acao=listarTimeline">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=timeline&acao=formTimeline&met=cadastroTimeline">Cadastro</a></li> 
		</ul>
	</div>

	<div id="principal">
		<form class="form" name="formTimeline" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('titulo_aba')); ">

			<div id="informacaoTimeline" class="content">
				<div class="content_tit">Dados Timeline:</div>
				<div class="box_ip">
					<label for="titulo">Título</label>
					<input type="text" name="titulo" id="titulo_aba" class='required' size="30" value="<?php echo $timeline['titulo']; ?>" />
				</div>
            <div class="box_ip">
               <label for="ano">Ano</label>
               <input type="text" name="ano" id="ano" class='required' size="30" maxlength="4" value="<?php echo $timeline['ano']; ?>" />
            </div>
				<!-- <div class="box_ip">
					<label for="data">Data</label>
					<input type="text" name="data" id="data" class='wDate required' size="30" maxlength="50" value="<?=!empty($timeline['data'])?date('d/m/Y',strtotime($timeline['data'])):''; ?>"/>
				</div> -->
            <div class="box_ip box_txt">
               <label for="texto">Texto</label>
               <textarea name="texto" id="texto" class="required" size="30"><?php echo $timeline['texto']; ?></textarea>
            </div>
				<div class="box_sel" style="width: 48.5%;">
					<label for="status">Status</label>
					<div class="box_sel_d">
						<select name="status" id="status" class='required'>
							<option value="1" <?php print($timeline['status'] == "1" ? ' selected="selected" ' : ''); ?>> Ativo </option>
							<option value="0" <?php print($timeline['status'] == "0" ? ' selected="selected" ' : ''); ?>> Inativo </option>
						</select>
					</div>
				</div>
            <div class="box_ip" style='width:50%;'>
                    <label  for="ididiomas">Idioma</label>
                    <div class="box_sel" style='width:100%;margin-left:0;'>
                        <label for="">Idioma</label>
                        <div class="box_sel_d" style='width:99%;'>
                            <select name="ididiomas" id="ididiomas" class='required'>
                                <?php foreach($idiomas as $key => $idioma):?>
                                    <option value="<?=$idioma['ididiomas']?>" <?php print ($timeline['ididiomas'] == $idioma['ididiomas'] ? ' selected="selected" ' : ''); ?> > <?=$idioma['idioma']?> </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                   </div>
                </div>
            <div class="box_ip imagem box_txt">
               <div class="content_tit" style="margin-left:0px;">Imagem</div>
               <?php if(empty($timeline['imagem'])):?>
                  <input type="file" id="imagem" class="img" name="imagem" tipo="imagem" value="<?php echo $timeline['imagem'] ?>"/>
               <?php else:?>
                  <input type="file" id="imagem" class="img" name="imagem" tipo="imagem" value="<?php echo $timeline['imagem'] ?>"/>
               <?php endif;?>
               <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>163x163</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
               <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                   <?php
                       $tamanho = explode('M', ini_get('upload_max_filesize'));
                       $tamanho = $tamanho[0];
                       echo $tamanho.'MB';
                   ?>
               </span>
               <br/>
               <?php
                   $caminho = '';
                   if($timeline['imagem'] !='' ){
                           $caminho = 'files/timeline/'.$timeline['imagem'];
                   }
               ?>
               <div>
                  <img src="<?php echo $caminho;?>" class="imagem_grande" width="100" <?php echo ($_REQUEST['met']=='cadastroTimeline') ? 'style="display:none;"' : '' ;?> />
               </div>
           </div>
			</div>

			<input type="hidden" name="imagem" id="imagem_old" size="30" value="<?php echo $timeline['imagem']; ?>" />
			<input type="hidden" name="idtimeline" value="<?php echo $idTimeline; ?>" />
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


<?php if($_REQUEST['acao'] == "listarTimeline"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	<div id="titulo">
		<!-- <img src="images/modulos/timeline_preto.png" height="22" width="24" alt="ico" /> -->
		<i class="fa fa-bars fa-2x"></i>
		<span>Listagem de Timeline</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=timeline&acao=listarTimeline">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=timeline&acao=formTimeline&met=cadastroTimeline">Cadastro</a></li>
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
			<div class="box_sel">
				<label for="adv_status">Status</label>
				<div class="box_sel_d">
					<select name="status" id="adv_status" class='required'>
						<option value=""></option>
						<option value="1"> Ativo </option>
						<option value="0"> Inativo </option>
					</select>
				</div>
			</div>
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>




	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Timeline</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=timeline&acao=formTimeline&met=cadastroTimeline"><img src="images/novo.png" alt="Cadastro Timeline" title="Cadastrar Timeline" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=timeline&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=timeline&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			requestInicio = "tipoMod=timeline&p="+preventCache+"&";
			ordem = "idtimeline";
			dir = "desc";
			$(document).ready(function(){
				preTableTimeline();
			});
			dataTableTimeline('<?php print $buscar; ?>');
			columnTimeline();
		</script>




	</div>

<?php } ?>

