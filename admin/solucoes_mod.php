<?php 
	 // Versao do modulo: 3.00.010416

	include_once "solucoes_class.php";
	include_once "includes/functions.php";
    $icone = buscaFW3(array('ordem' => 'nome', 'dir' => 'asc'));

    include_once "idiomas_class.php";
   $idiomas = buscaIdiomas(array('status'=>1));

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";
?>
<link rel="stylesheet" type="text/css" href="solucoes_css.css" />
<script type="text/javascript" src="solucoes_js.js"></script>

<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formSolucoes"){
	if($_REQUEST['met'] == "cadastroSolucoes"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "solucoes_script.php?opx=cadastroSolucoes";
		$metodo_titulo = "Cadastro Soluções";
		$idSolucoes = 0 ;

		// dados para os campos
		$solucoes['titulo'] = '';
		$solucoes['resumo'] = '';
		$solucoes['descricao'] = '';
		$solucoes['urlamigavel'] = '';
		$solucoes['title'] = '';
		$solucoes['description'] = '';
		$solucoes['keyword'] = '';
      $solucoes['ididiomas'] = '';
		// $solucoes['slogan_faq'] = '';
		// $solucoes['resumo_faq'] = '';
		$solucoes['thumbs'] = '';
		$solucoes['banner_topo'] = '';
      $solucoes_imagens = array();
	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "solucoes_script.php?opx=editSolucoes";
		$metodo_titulo = "Editar Soluções";
		$idSolucoes = (int) $_GET['idu'];
		$solucoes = buscaSolucoes(array('idsolucoes'=>$idSolucoes));
		$recursos = buscaRecursos(array('idsolucoes'=>$idSolucoes));
      	$servicos = buscaServicos(array('idsolucoes'=>$idSolucoes));
      	$imagem = buscaImagem(array('idsolucoes'=>$idSolucoes));
		if (count($solucoes) != 1) exit;
		$solucoes = $solucoes[0];
      $solucoes_imagens = buscaSolucoes_imagem(array("idsolucoes"=>$solucoes['idsolucoes'],"ordem"=>'posicao_imagem',"dir"=>'ASC'));
	}
?>

	<div id="titulo">
		<!-- <img src="images/modulos/solucoes_preto.png" height="24" width="24" alt="ico" /> -->
		<i class="fa fa-bars fa-2x"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=solucoes&acao=listarSolucoes">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=solucoes&acao=formSolucoes&met=cadastroSolucoes">Cadastro</a></li> 
		</ul>
	</div>

	<div id="principal">
		<form class="form" id="formSolucoes" name="formSolucoes" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data" onsubmit="return verificarCampos(new Array('titulo_aba')); " >

			<div id="informacaoSolucoes" class="content">
				<div class="content_tit">Dados Solucoes:</div>
					<div class="box_ip box_txt">
						<label for="titulo_aba">Título</label>
						<input type="text" name="titulo" id="titulo_aba" class='required' size="30" value="<?php echo $solucoes['titulo']; ?>" />
					</div>
					<div class="box_ip box_txt">
						<label for="resumo">Resumo</label>
						<textarea name="resumo" id="resumo" class="required" size="30"><?php echo $solucoes['resumo']; ?></textarea>
					</div>
					<div class="box_ip" style="width:100%;margin-bottom:10px;">
						<label for="descricao">Descrição</label>
						<!-- <div> -->
							<textarea name="descricao" id="descricao" class="required" value='' size="30"><?php echo $solucoes['descricao']; ?></textarea>
						<!-- </div> -->
					</div>

               <div class="box_ip" style='width:30%;'>
                   <label  for="ididiomas">Idioma</label>
                   <div class="box_sel" style='width:100%;margin-left:0;'>
                       <label for="">Idioma</label>
                       <div class="box_sel_d" style='width:99%;'>
                           <select name="ididiomas" id="ididiomas" class='required'>
                               <!-- <option></option> -->
                                <?php foreach($idiomas as $key => $i):?>
                                   <option value="<?=$i['ididiomas']?>" <?php print ($solucoes['ididiomas'] == $i['ididiomas'] ? ' selected="selected" ' : ''); ?> > <?=$i['idioma']?> </option>
                                <?php endforeach;?>
                           </select>
                       </div>
                  </div>
               </div>

					<div class="content_seo" style="width:100%;border-top:1px solid #e2e4e7;padding-top:20px;"> 
						<label class='label' style="font-weight:bold;">SEO:</label>
						<div class="box_ip box_txt">
							<label for="urlamigavel">Url</label>
							<input type="text" name="urlamigavel" id="urlamigavel" class='required' size="30" value="<?php echo $solucoes['urlamigavel']; ?>" />
							<input type="hidden" name="urlrewriteantigo" id="urlrewriteantigo" value="<?= $solucoes['urlamigavel']; ?>" />
						</div>
						<div class="box_ip box_txt">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" class='required' size="30" value="<?php echo $solucoes['title']; ?>" />
						</div>
						<div class="box_ip box_txt">
							<label for="description">Description</label>
							<textarea name="description" id="description" value='' class="" size="30"><?php echo $solucoes['description']; ?></textarea>
						</div>
						<div class="box_ip box_txt">
							<label for="keyword">Keywords</label>
							<textarea name="keyword" id="keyword" value='' class="" size="30"><?php echo $solucoes['keyword']; ?></textarea>
						</div>
                    </div>

					<div class="box_ip imagemUpload" style="text-align:center; width: 100%">
						<div>
	                        <label for="thumbs"><i class="fa fa-hand-pointer-o"></i> Selecione uma Thumb</label>
	                        <?php if(empty($solucoes['thumbs'])): ?>
	                        	<input type='file' name='thumbs' class=' inputImagem' id='thumbs' tipo="thumbs" data-name-modulo='solucoes' dimension-crop-width='177' dimension-crop-height='252' data-id-modulo='<?=$idSolucoes?>' size='30' maxlength='150'/>
	                        <?php else: ?>
	                        	<input type='file' name='thumbs' class='inputImagem' id='thumbs' tipo="thumbs" data-name-modulo='solucoes' dimension-crop-width='177' dimension-crop-height='252' data-id-modulo='<?=$idSolucoes?>' size='30'/>
	                        <?php endif;?>
	                    </div>
                        <img style="<?php echo (!empty($solucoes['thumbs']))?"":"display:none;";?>" src="<?php echo (!empty($solucoes['thumbs']))?"files/solucoes/".$solucoes['thumbs']:"https://via.placeholder.com/133x100";?>" height="250" id="file-thumbs" >
                        <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>300x374</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                            <?php
                            $tamanho = explode('M', ini_get('upload_max_filesize'));
                            $tamanho = $tamanho[0];
                            echo $tamanho.'MB';
                            ?>
                        </span>
                    </div>
                    <div class="box_ip imagemUpload" style="text-align:center; width: 100%">
                    	<div>
	                        <label for="banner_topo"><i class="fa fa-hand-pointer-o"></i> Selecione um Banner</label>
	                        <?php if(empty($solucoes['banner_topo'])): ?>
	                        	<input type='file' name='banner_topo' class=' inputImagem' id='banner_topo' tipo="banner_topo" data-name-modulo='solucoes' dimension-crop-width='177' dimension-crop-height='252' data-id-modulo='<?=$idSolucoes?>' size='30' maxlength='150'/>
	                        <?php else: ?>
	                        	<input type='file' name='banner_topo' class='inputImagem' id='banner_topo' tipo="banner_topo" data-name-modulo='solucoes' dimension-crop-width='177' dimension-crop-height='252' data-id-modulo='<?=$idSolucoes?>' size='30'/>
	                        <?php endif;?>
	                       </div>
                        <img style="<?php echo (!empty($solucoes['banner_topo']))?"":"display:none;";?>" src="<?php echo (!empty($solucoes['banner_topo']))?"files/solucoes/".$solucoes['banner_topo']:"https://via.placeholder.com/133x100";?>" height="250" id="file-banner_topo" >
                        <p class="pre">Tamanho mínimo recomendado: <span class='tamFull'>1220x523px</span> (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que:</strong>
                            <?php
                            $tamanho = explode('M', ini_get('upload_max_filesize'));
                            $tamanho = $tamanho[0];
                            echo $tamanho.'MB';
                            ?>
                        </span>
                    </div>

                    <!-- =======================Diferenciais========================== -->

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
	                                <th style="width: 10%;">&nbsp;</th><th style="width: 10%;"></th>
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
	                                        		  <img src="https://via.placeholder.com/100?text=Upload+Foto" style="max-width: 30px" class="img-upload-recursos img-recursos-<?=$key;?>" data-key="<?=$key;?>" />
	                                        	   <?php else:?>
	                                           		<img src="files/recursos/<?=$rec['imagem'];?>" style="max-width: 30px" class="img-upload-recursos img-recursos-<?=$key;?>" data-key="<?=$key;?>" />
	                                            <?php endif;?>
	                                            <input type="file" name="recursos[<?=$key;?>][imagem]" class="file-upload-recursos upload-recursos-<?=$key;?>" data-key="<?=$key;?>" style="display:none">
	                                            <span style="font-size:11px">Tamanho recomendado 30x30px </span>
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

				    <!-- =======================Fim Diferenciais========================== -->

                <!-- =======================Serviços========================== -->

                    <div class="listaServicos" style="float: left; width: 100%">
                       <div class="content_tit">
                           <label>Serviços</label><br/>
                           <a href="javascript:;" class="btn btn-servicos"><i class="fa fa-plus"></i> Adicionar</a>
                       </div>
                       <div class="gridLista" id="gridServicos">
                           <table class="table" id="tableServicos">
                               <thead>
                               <tr>
                                   <th align="center" style="width: 20%;">Imagem/Ícone</th>
                                   <th style="text-align: left;width: 30%;" class=""></th>
                                   <th style="text-align: left;width: 40%;" class=""></th>
                                   <th style="width: 10%;">&nbsp;</th><th style="width: 10%;"></th>
                               </tr>
                               </thead>
                               <tbody class="servicos">
                               <?php if(isset($servicos) && !empty($servicos)):?>
                                   <?php foreach($servicos as $key => $rec):
                                     $icones_Edit = buscaFW3(array('idfw' => $rec['icone']));
                                 $icones_Edit = $icones_Edit[0];?>

                                       <tr class="box-servicos removeServicos-<?=$key;?>">
                                           <td align="center" class="td-padding">
                                               <?php if(empty($rec['imagem'])):?>
                                                  <img src="https://via.placeholder.com/100?text=Upload+Foto" style="max-width: 30px" class="img-upload-servicos img-servicos-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php else:?>
                                                   <img src="files/servicos/<?=$rec['imagem'];?>" style="max-width: 30px"  class="img-upload-servicos img-servicos-<?=$key;?>" data-key="<?=$key;?>" />
                                               <?php endif;?>
                                               <input type="file" name="servicos[<?=$key;?>][imagem]" class="file-upload-servicos upload-servicos-<?=$key;?>" data-key="<?=$key;?>" style="display:none">
                                               <span style="font-size:11px">Tamanho recomendado 30x30px </span>
                                               <input type="hidden" name="servicos[<?=$key;?>][imagem]" value="<?=$rec['imagem'];?>">

		                                       <div id="mostrar_icone_servicos-<?=$key;?>" style="margin: 15px">
		                                           <i class='fa fa-<?=$icones_Edit['nome'];?> fa-2x '></i>
		                                           <input type="hidden" name="servicos[<?=$key;?>][icone]" value="<?=$rec['icone'];?>" id="imagem_icone-servicos-<?=$key;?>">
		                                       </div>

                                               <input type="button" value="Escolher ícone" class="btn button-escolher-icone-servicos" data-key="<?=$key;?>">

                                               <input type="hidden" name="servicos[<?=$key;?>][idservicos]" value="<?=$rec['idservicos'];?>">
                                               <input id='excluirServicos-<?=$key;?>' type="hidden" name="servicos[<?=$key;?>][excluirRecurso]" value="1">
                                           </td>
                                           <td colspan="2">
                                               <input type="text" class="box_txt inputRecursos w-100" name="servicos[<?=$key;?>][nome]" value="<?=$rec['nome'];?>" placeholder="Nome">
                                               <!-- <textarea rows="6" type="text" style="resize: vertical" class="box_txt inputRecursos w-100" name="servicos[<?=$key;?>][descricao]" placeholder="Descrição"><?=$rec['descricao'];?></textarea> -->
                                           </td>
                                           <td align="center">
                                               <span class="excluirServicos" data-key="<?=$key;?>">
                                                   <b class="fa fa-trash ico-del"></b>
                                               </span>
                                           </td>
                                       </tr>

                                       <tr class="removeServicos-<?=$key;?>">
                                          <td colspan="4">
                                             <div id="escolha-icone-servicos-<?=$key;?>"><div class="box_ip div-icones-servicos" style="width: 100% !important;"></div></div>
                                          </td>
                                       </tr>

                                   <?php endforeach;?>
                               <?php endif;?>
                               </tbody>
                           </table>
                       </div>
                   </div>

                   <div style="display: none;" class="div-mostra-icones-servicos div-icones">
                    <input type="text" name="pesquisar_icone" class="pesquisar_icone-servicos" placeholder="Pesquise um icone" style="margin-bottom: 10px;">
                    <div class="icone_pai-servicos">
                        <?php foreach ($icone as $key => $i) : ?>
                            <div style="width:6%; display: inline-block;" data-toggle="tooltip" title="<?= $i['nome']; ?>">
                                <i class="fa fa-<?= $i['nome']; ?> icone_icone-servicos" data-id="<?= $i['idfw']; ?>" data-nome="<?= $i['nome']; ?>" style="padding:11px; cursor: pointer;"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- =======================Fim Serviços========================== -->

                <!-- =======================Imagem========================== -->

                    <div class="listaImagem" style="float: left; width: 100%">
                       <div class="content_tit">
                           <label>Imagem</label><br/>
                           <a href="javascript:;" class="btn btn-imagem"><i class="fa fa-plus"></i> Adicionar</a>
                       </div>
                       <div class="gridLista" id="gridImagem">
                           <table class="table" id="tableImagem">
                               <thead>
                               <tr>
                                   <th align="center" style="width: 20%;">Imagem/Ícone</th>
                                   <th style="text-align: left;width: 30%;" class=""></th>
                                   <th style="text-align: left;width: 40%;" class=""></th>
                                   <th style="width: 10%;">&nbsp;</th><th style="width: 10%;"></th>
                               </tr>
                               </thead>
                               <tbody class="imagem">
                               <?php if(isset($imagem) && !empty($imagem)):?>
                                   <?php foreach($imagem as $key => $rec):
                                     $icones_Edit = buscaFW3(array('idfw' => $rec['icone']));
                                 $icones_Edit = $icones_Edit[0];?>

                                       <tr class="box-imagem removeImagem-<?=$key;?>">
                                           <td align="center" class="td-padding">
                                                <?php if(empty($rec['imagem'])):?>
                                                  <img src="https://via.placeholder.com/100?text=Upload+Foto" width="100"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php else:?>
                                                   <img src="files/imagem/<?=$rec['imagem'];?>" width="100"  class="img-upload img-<?=$key;?>" data-key="<?=$key;?>" />
                                                <?php endif;?>
                                               <input type="file" name="imagem[<?=$key;?>][imagem]" class="file-upload upload-<?=$key;?>" data-key="<?=$key;?>" style="display:none">
                                               <span style="font-size:11px">Tamanho recomendado 634x415px </span>
                                               <input type="hidden" name="imagem[<?=$key;?>][imagem]" value="<?=$rec['imagem'];?>">

		                                       <div id="mostrar_icone_imagem-<?=$key;?>" style="margin: 15px">
		                                           <i class='fa fa-<?=$icones_Edit['nome'];?> fa-2x '></i>
		                                           <input type="hidden" name="imagem[<?=$key;?>][icone]" value="<?=$rec['icone'];?>" id="imagem_icone-imagem-<?=$key;?>">
		                                       </div>

                                               <input type="button" value="Escolher ícone" class="btn button-escolher-icone-imagem" data-key="<?=$key;?>">

                                               <input type="hidden" name="imagem[<?=$key;?>][idimagem]" value="<?=$rec['idimagem'];?>">
                                               <input id='excluirImagem-<?=$key;?>' type="hidden" name="imagem[<?=$key;?>][excluirRecurso]" value="1">
                                           </td>
                                           <td colspan="2">
                                               <input type="text" class="box_txt inputRecursos w-100" name="imagem[<?=$key;?>][nome]" value="<?=$rec['nome'];?>" placeholder="Nome">
                                               <textarea rows="6" type="text" style="resize: vertical" class="box_txt inputRecursos w-100" name="imagem[<?=$key;?>][descricao]" placeholder="Descrição"><?=$rec['descricao'];?></textarea>
                                           </td>
                                           <td align="center">
                                               <span class="excluirImagem" data-key="<?=$key;?>">
                                                   <b class="fa fa-trash ico-del"></b>
                                               </span>
                                           </td>
                                       </tr>

                                       <tr>
                                          <td colspan="4">
                                             <div id="escolha-icone-imagem-<?=$key;?>"><div class="box_ip div-icones-imagem" style="width: 100% !important;"></div></div>
                                          </td>
                                       </tr>

                                   <?php endforeach;?>
                               <?php endif;?>
                               </tbody>
                           </table>
                       </div>
                   </div>

                   <div style="display: none;" class="div-mostra-icones-imagem div-icones">
                    <input type="text" name="pesquisar_icone" class="pesquisar_icone-imagem" placeholder="Pesquise um icone" style="margin-bottom: 10px;">
                    <div class="icone_pai-imagem">
                        <?php foreach ($icone as $key => $i) : ?>
                            <div style="width:6%; display: inline-block;" data-toggle="tooltip" title="<?= $i['nome']; ?>">
                                <i class="fa fa-<?= $i['nome']; ?> icone_icone-imagem" data-id="<?= $i['idfw']; ?>" data-nome="<?= $i['nome']; ?>" style="padding:11px; cursor: pointer;"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- =======================Fim Imagem========================== -->

                <!-- =======================Galeria======================== -->

                  <div class="box_ip" style="width:100%;" id="solucoes_imagem">
                     <div class="content_tit" style="margin-left:0; padding-left:5px;">Fotos Galeria</div>
                     <!--input FILE -->
                     <input style="width:50%; margin-left:5px;" id="image" name="image"  type="file" multiple />
                     <div class='tamanhoImagem'>
                        <p class="pre">Tamanho mínimo recomendado: 326x247px (ou maior proporcional)  -  Extensão recomendada: jpg, png</p>
                        <span class='maoir'><strong>O arquivo não pode ser maior que:</strong> 
                           <?php 
                              //echo ini_get('upload_max_filesize').'B<br>';
                              $tamanho = explode('M', ini_get('upload_max_filesize'));
                              $tamanho = $tamanho[0];
                              echo $tamanho.'MB'; 
                           ?>  
                           <input type="hidden" id="fileMax" value="<?= $tamanho ?>" />
                        </span>
                     </div> 

                     <!-- listagem das imagens -->
                     <div class="box_ip content-image" id="content-image" style="width:100%; margin-left:5px;">
                        <!-- INÍCIO DRAG N' DROP-->  
                        <div class="box_ip content-image" id="content-image" >
                           <div style="overflow:hidden"></div>
                           <ul id="sortable">  
                              <?php
                                 if(!empty($solucoes_imagens)){
                                    //LEMBRE-SE QUE A BUSCA DA TABELA solucoes_imagem ORDENA PELO CAMPO posicao_imagem
                                    //DESTE MODO ESSE FOREACH JÁ ALOCARÁ CADA IMAGEM EM SUA RESPECTIVA POSIÇÃO                      
                                    $posicao = 1;
                                    foreach($solucoes_imagens as $imagem){
                                       $caminho = 'files/solucoes/galeria/thumb_'.$imagem['nome_imagem'];
                                       echo '<li class="ui-state-default'.$posicao.' move box-img" id="'.$posicao.'" idimagem="'.$imagem['idsolucoes_imagem'].'">';
                                       echo '<img src="'.$caminho.'" id="img'.$imagem['posicao_imagem'].'" class="imagem-gallery" style="opacity:1;" />';
                                       echo '<a href="#" class="editImagemDescricao" idImagem="'.$imagem['idsolucoes_imagem'].'">';
                                       echo '<button class="edit"></button>'; 
                                       echo '</a>';
                                       echo '<a href="#" class="excluirImagem" idImagemDelete="'.$imagem['idsolucoes_imagem'].'">';
                                       echo '<button class="delete"></button>';  
                                       echo '</a>'; 

                                       // echo '<a href="#" class="postImagem" idImagemPost="'.$imagem['idsolucoes_imagem'].'">';
                                       // echo '<button class="post_imagem"></button>';   
                                       // echo '</a>'; 

                                       echo '<input type="hidden" name="idsolucoes_imagem[]" value="'.$imagem['idsolucoes_imagem'].'">';
                                       echo '<input type="hidden" name="descricao_imagem[]" value="'.$imagem['descricao_imagem'].'">';
                                       echo '<input type="hidden" name="imagem_solucoes[]" value="'.$imagem['nome_imagem'].'">';
                                       echo '<input type="hidden" name="posicao_imagem[]" value="'.$imagem['posicao_imagem'].'">';
                                       echo '</li>'; 
                                       $posicao++;
                                    }
                                 } 
                              ?> 
                           </ul>
                        </div> 
                     </div>  
                  </div>

                <!-- =======================Fim Galeria======================== -->

					<!-- <div class="box_ip box_txt">
						<label for="slogan_faq">Slogan do Faq</label>
						<input type="text" name="slogan_faq" id="slogan_faq" class='required' size="30" value="<?php echo $solucoes['slogan_faq']; ?>" />
					</div>
					<div class="box_ip box_txt">
						<label for="resumo_faq">Resumo do Faq</label>
						<textarea name="resumo_faq" id="resumo_faq" class="required" size="30"><?php echo $solucoes['resumo_faq']; ?></textarea>
					</div> -->
			</div>

         <input type="hidden" name="grid-recursos" value="0">
         <input type="hidden" name="grid-servicos" value="0">
         <input type="hidden" name="grid-imagem" value="0">
			<input type="hidden" name="thumbs" id="thumbs_old" size="30" value="<?php echo $solucoes['thumbs']; ?>" />
			<input type="hidden" name="banner_topo" id="banner_topo_old" size="30" value="<?php echo $solucoes['banner_topo']; ?>" />
			<input type="hidden" id="mod" name="mod" value="<?= ($idSolucoes == 0)? "cadastro":"editar"; ?>" />
			<input type="hidden" id="idsolucoes" name="idsolucoes" value="<?php echo $idSolucoes; ?>" />
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


<?php if($_REQUEST['acao'] == "listarSolucoes"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	<div id="titulo">
		<!-- <img src="images/modulos/solucoes_preto.png" height="22" width="24" alt="ico" /> -->
		<i class="fa fa-bars fa-2x"></i>
		<span>Listagem de Soluções</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=solucoes&acao=listarSolucoes">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=solucoes&acao=formSolucoes&met=cadastroSolucoes">Cadastro</a></li>
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
				<li class="abas_list_li action"><a href="javascript:void(0)">Soluções</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=solucoes&acao=formSolucoes&met=cadastroSolucoes"><img src="images/novo.png" alt="Cadastro Solucoes" title="Cadastrar Solucoes" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=solucoes&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=solucoes&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
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
			requestInicio = "tipoMod=solucoes&p="+preventCache+"&";
			ordem = "idsolucoes";
			dir = "desc";
			$(document).ready(function(){
				preTableSolucoes();
			});
			dataTableSolucoes('<?php print $buscar; ?>');
			columnSolucoes();
		</script>




	</div>

<?php } ?>

<!--/////////////////////////////////////////////////////////-->
<!--////////////// FORMULARIOS PARA A GALERIA ////////////////-->
<!--////////////////////////////////////////////////////////-->

<!--data dialog descrição-->
<div id="boxDescricao" style="display:none;">
   <div id="principal">
      <form class="form" name="formDescricaoImagem" id="formDescricaoImagem" method="post" action="">
         <div id="informacaoGaleria" class="content" style="width: 75%;">                      
            <div class="content_tit"></div>     
               <div class="box_ip" >
               <label  for="descricao_imagem">Descrição</label>
               <input type="text" name="descricao_imagem" id="descricao_imagem"   />
               <input type="hidden" id="idImagem" value="" /> 
               <input type="hidden" id="posImagem" value="" />
            </div>
            <input type="submit" value="Salvar" class="btSaveDescricao button" />
         </div>
      </form>
   </div>
</div>   
<!--Fim dialog descrição-->   

<!--data dialog exclusão de imagem-->
<div id="excluirImagem" style="display:none;">
   <div id="principal">
      <form class="form" name="formDeleteImagem" id="formDeleteImagem" method="post" action="">
         <div id="informacaoGaleria" class="content">                      
            <div class="content_tit"></div>   
            <input type="hidden" id="idPosicao" value="" />  
            <input type="button" value="NÃO" id="cancelar" class="btCancelarExclusao button cancel" />                           
            <input type="submit" value="SIM" class="btExcluirImagem button"/>
         </div>
      </form>
   </div>
</div>   
<input type="hidden" value="<?=ENDERECO?>" name="_endereco" id="_endereco" />
<!--Fim dialog exclusão de imagem-->