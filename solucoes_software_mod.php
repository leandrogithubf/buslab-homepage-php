<main>
	<!--####################
		BANNER PAGE
	####################-->
	<div class="page-banner-wrapper height flex-container flex-center-start box-mode m-b-lg">
		<div class="layout-max-width overflow-v">
			<div class="page-banner-title-wrapper left ghost">
				<h1 class="title primary left"><?=$p['titulo']?></h1>
			</div>
		</div>
		<img src="<?=ENDERECO?>admin/files/solucoes/<?=$p['banner_topo']?>" class="animation-zoomInOut-panView" alt="banner" aria-hidden="true">
	</div>
	
	<!--#######################
		SECTION: DESCRIÇÃO
	#######################-->
	<section class="page-stripe pure-g box-mode m-b-lg">
		<div class="layout-max-width">
			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-1-2 pure-u-xl-1-2 box-mode p-r-lg m-b-4">
				<h2 data-sal="slide-down" class="subtitle"><?=$p['titulo']?></h2>
				<p data-sal="fade" class="paragraph">
					<?=$p['descricao']?>
				</p>
				<a data-sal="flip-up" href="javascript:void(0)" class="btn primary" data-modal-btn="schedule-conversation"><?=$solucoes_agendar_conversa_agora?></a>
			</div>
         <?php if(!empty($p['servicos'])):?>
   			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-1-2 pure-u-xl-1-2 box-mode m-b-4">
   				<div class="flex-wrap flex-container flex-direction-row">
                  <?php foreach($p['servicos'] as $key => $s):?>
      					<div data-sal="zoom-out" class="shadow card mini box-mode m-b-sm">
      						<div class="card-header-icon">
                           <?php if(empty($s['imagem'])):?>
                              <?php foreach($s['icone'] as $key => $icone):?>
         							  <i class="fa fa-<?=$icone['nome']?> fa-1x icon icon-thin-advantage" role="icon"></i>
                              <?php endforeach;?>
                           <?php else:?>
                              <img width="18" class="solucoes-interna-servicos" alt="imagem" src="<?=ENDERECO?>admin/files/servicos/<?=$s['imagem']?>">
                           <?php endif;?>
      						</div>
      						<div class="card-body">
      							<p class="paragraph"><?=$s['nome']?></p>
      						</div>
      					</div>
                  <?php endforeach;?> 
   				</div>
   			</div>
         <?php endif;?>
         <?php if(!empty($p['diferenciais'])):?>
   			<div class="flex-wrap pure-u-1 flex-container flex-direction-row flex-justify-space-between box-mode m-b-7">
               <?php for($i = 0; $i < count($p['diferenciais']);$i+=3):?>
      				<ul class="list-checked-circle box-mode"> <!--removed: p-r-4_5-->
                     <?php if(!empty($p['diferenciais'][$i])):?>
      					 <li data-sal="zoom-in">
                        <?php if(empty($p['diferenciais'][$i]['imagem'])):?>
                           <i class="fa fa-<?=$p['diferenciais'][$i]['icone'][0]['nome']?> fa-1x"></i>&nbsp;&nbsp;<?=$p['diferenciais'][$i]['nome']?>
                        <?php else:?>
                           <img class="solucoes-modais-diferenciais" width="18" alt="imagem" src="<?=ENDERECO?>admin/files/recursos/<?=$p['diferenciais'][$i]['imagem']?>" >&nbsp;&nbsp;<?=$p['diferenciais'][$i]['nome']?>
                        <?php endif;?>
                     </li>
                     <?php endif;?>
                     <?php if(!empty($p['diferenciais'][$i+1])):?>
      					 <li data-sal="zoom-in">
                        <?php if(empty($p['diferenciais'][$i+1]['imagem'])):?>
                           <i class="fa fa-<?=$p['diferenciais'][$i+1]['icone'][0]['nome']?> fa-1x"></i>&nbsp;&nbsp;<?=$p['diferenciais'][$i+1]['nome']?>
                        <?php else:?>
                           <img class="solucoes-modais-diferenciais" width="18" alt="imagem" src="<?=ENDERECO?>admin/files/recursos/<?=$p['diferenciais'][$i+1]['imagem']?>">&nbsp;&nbsp;<?=$p['diferenciais'][$i+1]['nome']?>
                        <?php endif;?>
                     </li>
                     <?php endif;?>
                     <?php if(!empty($p['diferenciais'][$i+2])):?>
      					 <li data-sal="zoom-in">
                        <?php if(empty($p['diferenciais'][$i+2]['imagem'])):?>
                           <i class="fa fa-<?=$p['diferenciais'][$i+2]['icone'][0]['nome']?> fa-1x"></i>&nbsp;&nbsp;<?=$p['diferenciais'][$i+2]['nome']?>
                        <?php else:?>
                           <img class="solucoes-modais-diferenciais" width="18" alt="imagem" src="<?=ENDERECO?>admin/files/recursos/<?=$p['diferenciais'][$i+2]['imagem']?>">&nbsp;&nbsp;<?=$p['diferenciais'][$i+2]['nome']?>
                        <?php endif;?>
                     </li>
                     <?php endif;?>
      				</ul>
               <?php endfor;?>
   			</div>
	      <?php endif;?>
         <?php if(!empty($p['imagem'])):?>
   			<div class="pure-u-1">
   				<div data-sal="fade" class="solucoes-notebook">
   					<div class="notebook-slider-wrapper">
   						<div class="notebook-slider-nav-wrapper">
   							<a data-sal="slide-right" data-sal-delay="500" href="javascript:void(0)" class="nav prev prevent-default" aria-label="slide anterior"></a>
   							<a data-sal="slide-left" data-sal-delay="500" href="javascript:void(0)" class="nav next prevent-default" aria-label="slide posterior"></a>
   						</div>
   						<div class="notebook-slider">
                        <?php foreach($p['imagem'] as $key => $img):?>
      							<div class="container text center">
      								<img src="<?=ENDERECO?>admin/files/imagem/<?=$img['imagem']?>" alt="placeholder">
      								<h2 class="subtitle"><?=$img['nome']?></h2>
      								<p class="paragraph">
      									<?=$img['descricao']?>
      								</p>
      								<a href="javascript:void(0)" class="btn primary" data-modal-btn="schedule-conversation"><?=$solucoes_agendar_conversa_agora?></a>
      							</div>
                        <?php endforeach;?>
   						</div>				
   					</div>					
   				</div>
   			</div>
         <?php endif;?>

         <?php if(!empty($solucoes_imagens)):?>
            <div class="flex-container flex-center flex-direction-column flex-nowrap">
               <h2 data-sal="slide-down" class="subtitle"><?=$solucoes_alta_performance?></h2>
               <p data-sal="slide-up" class="paragraph" style="text-align: center;">
                  <?=$solucoes_alta_performance_texto?>
               </p>
               <a data-sal="zoom-in" href="javascript:void(0)" class="btn primary" data-modal-btn="schedule-conversation"><?=$solucoes_agendar_conversa_agora?></a>
               <div class="flex-container flex-start-start flex-direction-row flex-wrap pure-u-1 box-mode m-b-md">
                  <?php foreach($solucoes_imagens as $key => $si):?>
                     <img data-sal-delay="100" data-sal="flip-<?=(($key+1)%2)==1?'right':'left'?>" class="pure-u-1-3 pure-img" src="<?=ENDERECO?>admin/files/solucoes/galeria/<?=$si['nome_imagem']?>" alt="placeholder">
                  <?php endforeach;?>
               </div>
            </div>
         <?php endif;?>
		</div>
	</section>
	
	<!--####################
		PAGE BANNER
	####################-->
	<div class="m-0 bg-gray-100 page-banner-wrapper flex-container pure-g box-mode p-t-8 p-b-4">	
		<div class="container flex-container flex-direction-row flex-wrap flex-align-center flex-justify-space-between">
			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-1-2 pure-u-xl-1-2 box-mode m-b-lg p-r-lg">
				<h1 data-sal="slide-down" class="title box-mode m-b-lg"><?=$solucoes_confira_outras_solucoes?></h1>
				<a data-sal="flip-up" data-sal-delay="500" href="javascript:void(0)" class="btn primary" data-modal-btn="schedule-conversation"><?=$solucoes_agendar_conversa_agora?></a>
			</div>
	
			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-1-2 pure-u-xl-1-2">
				<div class="solucoes-card-md-slider box-mode">
               <?php foreach ($outras_solucoes as $key => $os):?>
   					<div data-sal="flip-right" class="card md hover-to-reveal full-image filter base">
   						<div class="card-body">
   							<p class="title ghost"><?=$os['titulo']?></p>
   							<a href="javascript:void(0)" class="btn ghost hover-visible box-mode m-t-1" data-modal-btn="solutions-<?=$os['urlamigavel']?>"><?=$home_saiba_mais?> >></a>
   						</div>
   						<img src="<?=ENDERECO?>admin/files/solucoes/<?=$os['thumbs']?>" alt="hardware">
   					</div>
	            <?php endforeach;?>
				</div>
				<div data-sal="fade" data-sal-delay="500" class="solucoes-card-md-slider-nav pure-u-1"></div>
			</div>
		</div>
	</div>
	
	<?php include_once("includes/modais.php");?>
	<?php include_once("includes/floating_vertical_bar.php");?>
</main>