<?php 
	 // Versao do modulo: 3.00.010416

	include_once "clientes_class.php";
   include_once "atuacao_class.php";

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";

   $atuacoes = buscaAtuacao();
?>
<link rel="stylesheet" type="text/css" href="clientes_css.css" />
<script type="text/javascript" src="clientes_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formClientes"){
	if($_REQUEST['met'] == "cadastroClientes"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "clientes_script.php?opx=cadastroClientes";
		$metodo_titulo = "Cadastro Clientes";
		$idClientes = 0 ;

		// dados para os campos
		$clientes['idclientes'] = "";
      $clientes['nome'] = "";
		$clientes['logo'] = "";
      $clientes['atuacoes'] = "";
		// $clientes['categoria'] = "";
		// $clientes['texto'] = "";
		// $clientes['imagem'] = "";
		// $clientes['servicos'] = "";
      // $clientes['destaque'] = "";
	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "clientes_script.php?opx=editClientes";
		$metodo_titulo = "Editar Clientes";
		$idClientes = (int) $_GET['idu'];
		$clientes = buscaClientes(array('idclientes'=>$idClientes));
		if (count($clientes) != 1) exit;
		$clientes = $clientes[0];
	}
?>

	<div id="titulo">
		<!-- <img src="images/modulos/clientes_preto.png" height="24" width="24" alt="ico" /> -->
      <i class="fa fa-handshake-o"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=clientes&acao=listarClientes">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=clientes&acao=formClientes&met=cadastroClientes">Cadastro</a></li>
		</ul>
	</div>




	<div id="principal">
		<form class="form" name="formClientes" method="post" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('nome', 'logo')); " >

			<div id="informacaoClientes" class="content">
				<div class="content_tit">Dados Clientes:</div>
					<div class="box_ip">
						<label for="nome">Nome</label>
						<input class="required" type="text" name="nome" id="nome" size="30" maxlength="255" value="<?php echo $clientes['nome']; ?>" />
					</div>
					<!-- <div class="box_ip" style="width: 100%;">
						<label for="texto">Texto</label>
						<textarea name="texto" class="" id="texto" cols="34" rows="4" ><?php echo $clientes['texto']; ?></textarea>
					</div>
               <div class="box_ip" style='width:30%;'>
                  <label for="destaque">Destaque</label>
                  <div class="box_sel" style='width:100%;margin-left:0;'>
                     <label for="">Destaque</label>
                     <div class="box_sel_d" style='width:99%;'>
                         <select name="destaque" id="destaque" class='required'>
                             <option value="N" <?php print ($clientes['destaque'] == 'N' ? ' selected="selected" ' : ''); ?> > Não </option>
                             <option value="S" <?php print ($clientes['destaque'] == 'S' ? ' selected="selected" ' : ''); ?> > Sim </option>
                         </select>
                     </div>
                  </div>
               </div> -->
               <div class="box_cr" style="margin-bottom: 30px">
                  <p style="margin-left: 10px;">Atuações</p>
                  <div>
                     <?php
                        $atuacaoExp = explode(', ', $clientes['atuacoes']);
                     ?>
                     <?php foreach($atuacoes as $key => $atuacao):?>
                        <label>
                           <input style="margin: 0px" name="atuacoes[]" class="atuacoesCheckbox" value="<?=$atuacao['idatuacao']?>" type="checkbox" <?=in_array($atuacao['idatuacao'], $atuacaoExp)?'checked':''?>>
                           <span><?=$atuacao['nome']?></span>
                        </label>
                     <?php endforeach;?>
                     <!-- <input id="atuacaoOrdem" type="hidden" name="atuacao" style="width: 100%" value="<?=!empty($clientes['atuacao'])?$clientes['atuacao'].', ':''?>">
                     <div style="display: inline-block;width: 100%;margin-top: 10px;">
                        <span id="atuacaoOrdemVisivel"><strong>Ordem:&nbsp;</strong><?=$clientes['atuacao']?></span>
                     </div> -->
                  </div>
               </div>
					<div class="box_ip imagem" style="width: 100%;">
                        <div class="content_tit" style="margin-left:0px;">Logo</div>
                        <?php if(empty($clientes['logo'])):?>
                           <input type="file" id="logo" class=" img" name="logo" tipo="logo" value="<?php echo $clientes['logo'] ?>"/>
                        <?php else:?>
                           <input type="file" id="logo" class="img" name="logo" tipo="logo" value="<?php echo $clientes['logo'] ?>"/>
                        <?php endif;?>
                        <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>167x167</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                            <?php
                                $tamanho = explode('M', ini_get('upload_max_filesize'));
                                $tamanho = $tamanho[0];
                                echo $tamanho.'MB';
                            ?>
                        </span>
                        <?php
                            $caminho = '';
                            if($clientes['logo'] !='' ){
                                    $caminho = 'files/clientes/'.$clientes['logo'];
                            }
                        ?>
                        <img src="<?php echo $caminho;?>" class="imagem_logo" width="150" <?php echo ($_REQUEST['met']=='cadastroBanner') ? 'style="display:none;"' : '' ;?> />
                    </div>
					<!-- <div class="box_ip imagem">
                        <div class="content_tit" style="margin-left:0px;">Imagem</div>
                        <input type="file" id="imagem" class="img" name="imagem" tipo="imagem" value="<?php echo $clientes['imagem'] ?>"/>
                        <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>409x493</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                            <?php
                                $tamanho = explode('M', ini_get('upload_max_filesize'));
                                $tamanho = $tamanho[0];
                                echo $tamanho.'MB';
                            ?>
                        </span>
                        <?php
                            $caminho = '';
                            if($clientes['imagem'] !='' ){
                                    $caminho = 'files/clientes/'.$clientes['imagem'];
                            }
                        ?>
                        <img src="<?php echo $caminho;?>" class="imagem_grande" width="150" <?php echo ($_REQUEST['met']=='cadastroBanner') ? 'style="display:none;"' : '' ;?> />
                    </div> -->

			</div>

			<!-- <input type="hidden" id="banner_full" name="imagem" value="<?= $clientes['imagem'] ?>" class=''/> -->
            <input type="hidden" id="banner_logo" name="logo" value="<?= $clientes['logo'] ?>"  class=''/>
            <input type="hidden" id="mod" name="mod" value="<?= ($clientes['idclientes'] == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" id="idclientes" name="idclientes" value="<?php echo $idClientes; ?>" />
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


<?php if($_REQUEST['acao'] == "listarClientes"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	<div id="titulo">
		<i class="fa fa-handshake-o"></i>
		<span>Listagem de Clientes</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=clientes&acao=listarClientes">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=clientes&acao=formClientes&met=cadastroClientes">Cadastro</a></li>
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
				<li class="abas_list_li action"><a href="javascript:void(0)">Clientes</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=clientes&acao=formClientes&met=cadastroClientes"><img src="images/novo.png" alt="Cadastro Clientes" title="Cadastrar Clientes" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=clientes&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=clientes&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			requestInicio = "tipoMod=clientes&p="+preventCache+"&";
			ordem = "idclientes";
			dir = "desc";
			$(document).ready(function(){
				preTableClientes();
			});
			dataTableClientes('<?php print $buscar; ?>');
			columnClientes();
		</script>




	</div>

<?php } ?>

