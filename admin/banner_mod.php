<?php
	 // Versao do modulo: 2.20.130114

	include_once "banner_class.php";
    include_once "idiomas_class.php";

    $idiomas = buscaIdiomas(array('status'=>'1'));

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";

?>
<link rel="stylesheet" type="text/css" href="banner_css.css" />
<script type="text/javascript" src="banner_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formBanner"){
	if($_REQUEST['met'] == "cadastroBanner"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "banner_script.php?opx=cadastroBanner";
		$metodo_titulo = "Cadastro Banner";
		$idBanner = 0 ;

        // dados para os campos
        $banner['nome'] = "";
        $banner['link'] = "";
        $banner['ordem'] = 0;
        $banner['status'] = "";
        $banner['banner_full'] = "";
        $banner['banner_mobile'] = "";
        $banner['idbanner'] = "";
        $banner['dinamico'] = 0;
        $banner['subtitulo'] = "";
        $banner['titulo_botao'] = "";
        $banner['flutuante'] = "";
        $banner['ididiomas'] = "";
}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "banner_script.php?opx=editBanner";
		$metodo_titulo = "Editar Banner";
		$idBanner = $_GET['idu'];
		$banner = buscaBanner(array('idbanner'=>$idBanner));
		$banner = $banner[0];
	}
?>

	<div id="titulo">
		<i class="fa fa-picture-o" aria-hidden="true"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=banner&acao=listarBanner">Listagem</a></li>
		</ul>
	</div>


    <div id="principal">
    	<form class="form" name="formBanner" id="formBanner" method="post" action="<?php echo $action; ?>">
            <div id="informacaoBanner" class="content">
                <div class="content_tit">Dados Banner:</div>
                <div class="box_ip" style='width:100%;'>
                  <label  for="nome">Nome</label>
                  <input type="text" name="nome" id="nome" size="30" maxlength="255" value="<?php echo $banner['nome']; ?>" class='' />
                </div>

                <div style='clear:both;'>

                <div style='clear:both;'></div>

                <div class="box_ip" style='width:30%;'>
                    <label  for="status">Status</label>
                    <div class="box_sel" style='width:100%;margin-left:0;'>
                        <label for="">Status</label>
                        <div class="box_sel_d" style='width:99%;'>
                            <select name="status" id="status" class=''>
                                <!-- <option></option> -->
                                <option value="1" <?php print ($banner['status'] == "1" ? ' selected="selected" ' : ''); ?> > Ativo </option>
                                <option value="0" <?php print ($banner['status'] == "0" ? ' selected="selected" ' : ''); ?> > Inativo </option>
                            </select>
                        </div>
                   </div>
                </div>

                <div class="box_ip" style='width:30%;'>
                    <label  for="flutuante">Flutuante</label>
                    <div class="box_sel" style='width:100%;margin-left:0;'>
                        <label for="">Flutuante</label>
                        <div class="box_sel_d" style='width:99%;'>
                            <select name="flutuante" id="flutuante" class=''>
                                <!-- <option></option> -->
                                <option value="N" <?php print ($banner['flutuante'] == "N" ? ' selected="selected" ' : ''); ?> > Não </option>
                                <option value="S" <?php print ($banner['flutuante'] == "S" ? ' selected="selected" ' : ''); ?> > Sim </option>
                            </select>
                        </div>
                   </div>
                </div>

                <div class="box_ip" style='width:30%;'>
                    <label  for="ididiomas">Idioma</label>
                    <div class="box_sel" style='width:100%;margin-left:0;'>
                        <label for="">Idioma</label>
                        <div class="box_sel_d" style='width:99%;'>
                            <select name="ididiomas" id="ididiomas" class=''>
                                <?php foreach($idiomas as $key => $idioma):?>
                                    <option value="<?=$idioma['ididiomas']?>" <?php print ($banner['ididiomas'] == $idioma['ididiomas'] ? ' selected="selected" ' : ''); ?> > <?=$idioma['idioma']?> </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                   </div>
                </div>

                <div class="box_ip link_video" style='width:100%;'>
                    <label  for="link">Link</label>
                    <input type="text" name="link" id="link" size="30" maxlength="255" value="<?php echo $banner['link']; ?>" />
                </div>

                <div class="box_ip" style='width:30%;'>
                    <label  for="status">Tipo</label>
                    <div class="box_sel" style='width:100%;margin-left:0;'>
                        <label for="">Tipo</label>
                        <div class="box_sel_d" style='width:99%;'>
                            <select name="dinamico" id="dinamico" class=''>
                                <option></option>
                                <option value="1" <?= (($banner['dinamico']) ? ' selected="selected" ' : ''); ?> > Dinâmico </option>
                                <option value="0" <?= ((!$banner['dinamico']) ? ' selected="selected" ' : ''); ?> > Imagem </option>
                            </select>
                        </div>
                   </div>
                </div>

                <div class='bannerDinamico' <?= ((!$banner['dinamico']) ? 'style="display:none;"' : ''); ?>>
                    <div class="box_ip">
                      <label for="subtitulo">Subtítulo</label>
                      <input type="text" name="subtitulo" id="subtitulo" size="30" maxlength="255" value="<?= $banner['subtitulo']; ?>"/>
                    </div>
                    <div class="box_ip">
                      <label for="titulo_botao">Título Botão</label>
                      <input type="text" name="titulo_botao" id="titulo_botao" size="30" maxlength="100" value="<?= $banner['titulo_botao']; ?>"/>
                    </div>
                </div>
                <div style='clear:both;'></div>

                <div>
                     </div></div>
                    <!--################################## IMAGEM GRANDE #################################################
                    ###############################################################################################-->
                    <div class="box_ip imagem " style="width:50%">
                        <div class="content_tit" style="margin-left:0px;">Banner Full</div>
                        <input type="file" id="full" class="foto" name="full" tipo="banner_full" value="<?php echo $banner['banner_full'] ?>"/>
                        <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>1920x1080</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                            <?php
                                $tamanho = explode('M', ini_get('upload_max_filesize'));
                                $tamanho = $tamanho[0];
                                echo $tamanho.'MB';
                            ?>
                        </span>
                        <?php
                            $caminho = '';
                            if($banner['banner_full'] !='' ){
                                    $caminho = 'files/banner/'.$banner['banner_full'];
                            }
                        ?>
                        <img src="<?php echo $caminho;?>" class="imagem_grande" width="150" <?php echo ($_REQUEST['met']=='cadastroBanner') ? 'style="display:none;"' : '' ;?> />
                    </div>

                    <!--################################## FIM IMAGEM GRANDE #################################################
                    ###############################################################################################-->



                        <!--################################## IMAGEM PEQUENA #################################################
                        ###############################################################################################-->
                        <div class="box_ip imagem" style="width:50%">
                            <div class="content_tit" style="margin-left:0px;">Banner Mobile</div>
                            <input type="file" id="mobile" class="foto" name="mobile" tipo="banner_mobile" value="<?php echo $banner['banner_mobile'] ?>"/>
                            <p class="pre">Tamanho mínimo recomendado: <span class='tamMobile'>361x521</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                                <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                                    <?php
                                        //echo ini_get('upload_max_filesize').'B<br>';
                                        $tamanho = explode('M', ini_get('upload_max_filesize'));
                                        $tamanho = $tamanho[0];
                                        echo $tamanho.'MB';
                                    ?>
                                </span>
                                <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                            <?php
                            $caminho = '';
                            if($banner['banner_mobile']!=''){
                                    $caminho = 'files/banner/'.$banner['banner_mobile'];
                            }
                            ?>
                            <img src="<?php echo $caminho;?>" class="imagem_pequena" width="150"
                            <?php echo ($_REQUEST['met']=='cadastroBanner') ? 'style="display:none;"' : '' ;?> />
                        </div>

                        <!--################################## FIM IMAGEM PEQUENA #################################################
                         ###############################################################################################-->
                </div>


            <input type="hidden" name="ordem" id="ordem" value="<?php echo $banner['ordem'] ?>" />
            <input type="hidden" id="idbanner" name="idbanner" value="<?= $banner['idbanner'] ?>" />
            <input type="hidden" id="banner_full" name="banner_full" value="<?= $banner['banner_full'] ?>" class=''/>
            <input type="hidden" id="banner_mobile" name="banner_mobile" value="<?= $banner['banner_mobile'] ?>"  class=''/>
            <input type="hidden" id="mod" name="mod" value="<?= ($banner['idbanner'] == 0)? "cadastro":"editar"; ?>" />
            <input type="submit" value="Salvar" class="bt_save salvar" />
            <input type="button" value="Cancelar" class="bt_cancel cancelar" />
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


<?php if($_REQUEST['acao'] == "listarBanner"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	 <div id="titulo">
		<i class="fa fa-picture-o" aria-hidden="true"></i>
		<span>Listagem de Banner</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=banner&acao=formBanner&met=cadastroBanner">Cadastro</a></li>
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
			<div class="box_ip"><label for="adv1">Nome</label><input type="text" name="nome" id="adv1"></div>
            <div class="box_ip link_video">
                <label  for="adv_link">Link</label>
                <input type="text" name="link" id="adv_link" size="30" maxlength="255" value="" />
            </div>
            <div class="box_ip">
                <label for="adv_status">Status</label>
                <div class="box_sel" style='width:100%;padding: 0'>
                    <label for="">Status</label>
                    <div class="box_sel_d" style='width:100%;'>
                        <select name="status" id="adv_status">
                            <option></option>
                            <option value="1"> Ativo </option>
                            <option value="0"> Inativo </option>
                        </select>
                    </div>
               </div>
            </div>
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>
	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
                <li class="abas_list_li action"><a href="javascript:void(0)">Banners</a></li>
             </ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=banner&acao=formBanner&met=cadastroBanner"><img src="images/novo.png" alt="Cadastro Banner" title="Cadastrar Banner" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=banner&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=banner&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			requestInicio = "tipoMod=banner&p="+preventCache+"&";
			ordem = "ordem";
			dir = "asc";
			$(document).ready(function(){
				preTableBanner();
			});
			dataTableBanner('<?php print $buscar; ?>');
			columnBanner();
		</script>




	</div>

<?php } ?>
