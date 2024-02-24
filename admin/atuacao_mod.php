<?php 
	 // Versao do modulo: 3.00.010416

	include_once "atuacao_class.php";
   include_once "idiomas_class.php";

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";

   $idiomas = buscaIdiomas(array('status'=>1));
?>
<link rel="stylesheet" type="text/css" href="atuacao_css.css" />
<script type="text/javascript" src="atuacao_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formAtuacao"){
	if($_REQUEST['met'] == "cadastroAtuacao"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "atuacao_script.php?opx=cadastroAtuacao";
		$metodo_titulo = "Cadastro Atuação";
		$idAtuacao = 0 ;

		// dados para os campos
		$atuacao['nome'] = "";
		$atuacao['texto'] = "";
		$atuacao['imagem'] = "";
      $atuacao['ordem'] = 0;
      $atuacao['ididiomas'] = "";
	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "atuacao_script.php?opx=editAtuacao";
		$metodo_titulo = "Editar Atuação";
		$idAtuacao = (int) $_GET['idu'];
		$atuacao = buscaAtuacao(array('idatuacao'=>$idAtuacao));
		if (count($atuacao) != 1) exit;
		$atuacao = $atuacao[0];
	}
?>

	<div id="titulo">
		<i class="fa fa-info-circle"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=atuacao&acao=listarAtuacao">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=atuacao&acao=formAtuacao&met=cadastroAtuacao">Cadastro</a></li>
		</ul>
	</div>




	<div id="principal">
		<form class="form" name="formAtuacao" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome')); " >

			<div id="informacaoAtuacao" class="content">
				<div class="content_tit">Dados Atuação:</div>
					<div class="box_ip">
						<label for="nome">Nome</label>
						<input class="required" type="text" name="nome" id="nome" size="30" maxlength="255" value="<?php echo $atuacao['nome']; ?>" />
					</div>
                    <div class="box_ip" style='width:30%;'>
                       <label  for="ididiomas">Idioma</label>
                       <div class="box_sel" style='width:100%;margin-left:0;'>
                           <label for="">Idioma</label>
                           <div class="box_sel_d" style='width:99%;'>
                               <select name="ididiomas" id="ididiomas" class='required'>
                                   <?php foreach($idiomas as $key => $idioma):?>
                                       <option value="<?=$idioma['ididiomas']?>" <?php print ($atuacao['ididiomas'] == $idioma['ididiomas'] ? ' selected="selected" ' : ''); ?> > <?=$idioma['idioma']?> </option>
                                   <?php endforeach;?>
                               </select>
                           </div>
                      </div>
                   </div>
					<div class="box_ip" style="width: 100%;">
						<label for="texto">Texto</label>
						<textarea name="texto" class="" id="texto" cols="34" rows="4" ><?php echo $atuacao['texto']; ?></textarea>
					</div>
					<div class="box_ip imagem">
                        <div class="content_tit" style="margin-left:0px;">Imagem</div>
                        <input type="file" id="imagem" class="img <?=empty($como_funciona['imagem'])?'required':''?>" name="imagem" tipo="imagem" value="<?php echo $atuacao['imagem'] ?>"/>
                        <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>209x209</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                            <?php
                                $tamanho = explode('M', ini_get('upload_max_filesize'));
                                $tamanho = $tamanho[0];
                                echo $tamanho.'MB';
                            ?>
                        </span>
                        <?php
                            $caminho = '';
                            if($atuacao['imagem'] !='' ){
                                    $caminho = 'files/atuacao/'.$atuacao['imagem'];
                            }
                        ?>
                        <img src="<?php echo $caminho;?>" class="imagem_grande" width="150" <?php echo ($_REQUEST['met']=='cadastroBanner') ? 'style="display:none;"' : '' ;?> />
                    </div>

			</div>

			<input type="hidden" id="banner_full" name="imagem" value="<?= $atuacao['imagem'] ?>" class=''/>
         <input type="hidden" name="ordem" id="ordem" value="<?php echo $banner['ordem'] ?>" />
         <input type="hidden" id="mod" name="mod" value="<?= ($atuacao['idatuacao'] == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" id="idatuacao" name="idatuacao" value="<?php echo $idAtuacao; ?>" />
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


<?php if($_REQUEST['acao'] == "listarAtuacao"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	<div id="titulo">
		<i class="fa fa-info-circle"></i>
		<span>Listagem de Atuação</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=atuacao&acao=listarAtuacao">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=atuacao&acao=formAtuacao&met=cadastroAtuacao">Cadastro</a></li>
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
			<div class="box_ip"><label for="adv_logo">Logo</label><input type="text" name="logo" id="adv_logo"></div>
			<div class="box_ip"><label for="adv_categoria">Categoria</label><input type="text" name="categoria" id="adv_categoria"></div>
			<div class="box_ip"><label for="adv_idioma">Idioma</label><input type="text" name="idioma" id="adv_idioma"></div>
			<div class="box_ip"><label for="adv_texto">Texto</label><input type="text" name="texto" id="adv_texto"></div>
			<div class="box_ip"><label for="adv_imagem">Imagem</label><input type="text" name="imagem" id="adv_imagem"></div>
			<div class="box_ip"><label for="adv_servicos">Servicos</label><input type="text" name="servicos" id="adv_servicos"></div>
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>




	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Atuação</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=atuacao&acao=formAtuacao&met=cadastroAtuacao"><img src="images/novo.png" alt="Cadastro Atuacao" title="Cadastrar Atuacao" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=atuacao&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=atuacao&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			requestInicio = "tipoMod=atuacao&p="+preventCache+"&";
			ordem = "ordem";
			dir = "asc";
			$(document).ready(function(){
				preTableAtuacao();
			});
			dataTableAtuacao('<?php print $buscar; ?>');
			columnAtuacao();
		</script>




	</div>

<?php } ?>

