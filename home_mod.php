
<main>
	<!--##################
		HERO SLIDER
	##################-->
	<section class="page-stripe box-mode p-0 pure-g">
		<div class="hero-slider banner-slider-wrapper">
			<div class="banner-slider">
            <?php foreach ($banner as $key => $b):?>
               <?php 
                  if(!empty($b['link'])){
                     $link = "window.location.href = '".$b['link']."';";
                  }else{
                     $link = "";
                  }
               ?>
               <?php if($b['flutuante'] == "S"):?>
      				<div class="slide">
      					<div onclick="<?=$link?>" class="slide-max-width">
                        <?php if($b['dinamico'] == 1):?>
            					<div class="slide-content-text pure-u-1 pure-u-sm-1-1 pure-u-md-1-2 pure-u-lg-2-5 pure-u-xg-2-5">
            						<h1 class="title"><?=$b['nome']?></h1>
            						<p class="paragraph text small-plus"><?=$b['subtitulo']?></p>
                              <?php if(!empty($b['link'])):?>
            						   <a href="<?=$b['link']?>" class="btn primary"><?=$b['titulo_botao']?></a>
                              <?php else:?>
                                 <a href="javascript:void(0)" data-modal-btn="schedule-conversation" class="btn primary"><?=$b['titulo_botao']?></a>
                              <?php endif;?>
            					</div>
                        <?php endif;?>
      					</div>
      					<div class="slide-content-image">
      						<img id="hero-notebooks-floating" class="animation-theyAllFloatDownHere image overscreen offset-x pos-abs top-middle pure-img" src="<?=ENDERECO?>admin/files/banner/<?=$b['banner_full']?>" alt="<?=$b['nome']?>" aria-hidden="true">
      					</div>
      				</div>
               <?php else:?>
                  <div class="slide">
                     <div class="slide-max-width">
                        <div class="slide-content-text pure-u-1 pure-u-sm-1-1 pure-u-md-1-1 pure-u-lg-2-5 pure-u-xg-2-5">
                           <h1 class="title ghost"><?=$b['nome']?></h1>
                           <p class="paragraph ghost text small-plus"><?=$b['subtitulo']?></p>
                           <?php if(!empty($b['link'])):?>
                              <a href="<?=$b['link']?>" class="btn ghost"><?=$b['titulo_botao']?></a>
                           <?php else:?>
                              <a href="javascript:void(0)" data-modal-btn="schedule-conversation" class="btn ghost"><?=$b['titulo_botao']?></a>
                           <?php endif;?>
                        </div>                  
                     </div>
                     <div class="slide-content-image">
                        <img class="slide-full-image pure-img" src="<?=ENDERECO?>admin/files/banner/<?=$b['banner_full']?>" alt="<?=$b['nome']?>" aria-hidden="true">
                     </div>
                  </div>
               <?php endif;?>
            <?php endforeach;?>
				<!-- <div class="slide">
					<div class="slide-max-width">
						<div class="slide-content-text pure-u-1 pure-u-sm-1-1 pure-u-md-1-1 pure-u-lg-2-5 pure-u-xg-2-5">
							<h1 class="title ghost">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, ad!</h1>
							<p class="paragraph ghost text small-plus">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore, esse voluptas temporibus natus exercitationem hic omnis ipsam aliquid atque provident.</p>
							<a href="javascript:void(0)" data-modal-btn="schedule-conversation" class="btn ghost"><?=$cabecalho_agende_uma_conversa?></a>
						</div>						
					</div>
					<div class="slide-content-image">
						<img class="slide-full-image pure-img" src="https://picsum.photos/id/1061/1200/715" alt="notebooks" aria-hidden="true">
					</div>
				</div> -->
			</div>
		   <!-- HERO NAV -->
		   <div class="slider-max-width">
			   <div class="slider-nav pure-g">
			      <div class="slider-nav-content filter grayscale pure-u-1-2 pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-20-24 pure-u-xl-20-24" role="button" aria-label="navegar entre slides"></div>
		
			      <div class="flex-container flex-row flex-wrap flex-center-end pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-6-24 pure-u-xl-6-24">
				      <span><?=$home_conheca_a_buslab?></span>
				      <i class="icon icon-in-blk icon-btn icon-circle-arrow-down"></i>	      	
			      </div>
			   </div>   	
		   </div>
		</div>
	</section>
	
	<!--######################
		SECTION:QUEM SOMOS
	######################-->
	<section class="bg-gray-100 page-stripe pure-g">
		<div class="layout-max-width">
			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1-2 pure-u-lg-14-24 box-mode bd-rds-sm m-b-lg overflow-h">
				<div data-sal="slide-right" class="page-media flex-container">
					<!--
						youtube embed param
							560 x 369
					<iframe width="560" height="369" src="https://www.youtube.com/embed/gojq0-jkqDU?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
					
					<img src="./images/shutterstock_1859123998.jpg" class="pure-img animation-zoomOutIn" alt="mão segurando um celular com app de localização aberto">
				</div>
			</div>
			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1-2 pure-u-lg-10-24 box-mode p-l-lg mob:p-l-0">
				<h1 data-sal="slide-left" class="title"><?=$buslab_mas_o_que_exatamente_e?></h1>
				<p data-sal="slide-up" class="paragraph"><?=$buslab_mas_o_que_exatamente_e_texto?></p>
				<a data-sal="slide-up" href="<?=ENDERECO_IDIOMA?>buslab" class="btn primary"><?=$home_saiba_mais?> &gt;&gt;</a>
			</div>
		</div>
	</section>
	
	<!--############################
		SECTION: NOSSAS VANTAGENS
	############################-->
    <?php if(!empty($vantagens)):?>
    	<section class="page-stripe pure-g">
    		<div class="layout-max-width">
    			<h1 data-sal="slide-right" class="title text left bottom-line box-mode m-t-lg m-b-lg"><?=$home_nossas_vantagens?></h1>
    	
    			<div class="flex-wrap flex-container flex-direction-row flex-stretch-center">
    				<?php foreach($vantagens as $key => $v):?>
                   <div data-sal="zoom-out" class="shadow card hover hover-to-reveal">
                      <?php foreach($v['icone'] as $key => $icone):?>
                         <?php if($icone['idfw'] == 0):?>
                            <div class="card-header-icon">
                               <img src="<?=ENDERECO?>admin/files/vantagens/<?=$icone['nome']?>" class="icon icon-in-blk icon-advantage" alt="imagem">
                            </div>
                         <?php else:?>
                            <div class="card-header-icon">
                               <!-- <i class="icon icon-in-blk icon-advantage icon-circle-head"></i> -->
                               <i class="fa fa-<?=$icone['nome']?> fa-3x icon icon-advantage"></i>
                            </div>
                         <?php endif;?>
                      <?php endforeach;?>
    <!--    					<div class="card-header-icon">
       						<i class="icon icon-in-blk icon-advantage icon-circle-customer"></i>
       					</div> -->
       					<div class="card-body">
       						<p class="title"><?=$v['titulo']?></p>
       						<p class="paragraph"><?=$v['descricao']?></p>
       						<a href="javascript:void(0)" data-modal-btn="schedule-conversation" class="btn primary ghost hover-visible"><?=$cabecalho_agende_uma_conversa?></a>
       					</div>
       				</div>
                <?php endforeach;?>
    			</div>
    		</div>
    	</section>
    <?php endif;?>
	
	<!--#########################
		SECTION: COMO FUNCIONA
	#########################-->
    <?php if(!empty($comofunciona)):?>
    	<section id="how-it-work" class="page-stripe pure-g">
    		<div class="banner-slider-wrapper">
    			<div class="banner-slider-header">
    				<h1 class="title ghost box-mode m-r-md p-l-md"><?=$home_como_funciona?></h1>
    				<div class="banner-slider-nav">
    					<i class="icon icon-arrow-left" role="button" aria-label="slide anterior"></i>
    					<i class="icon icon-arrow-right" role="button" aria-label="slide posterior"></i>
    				</div>
    			</div>
    			<div class="banner-slider overflow-v">
    				
                <?php foreach($comofunciona as $key => $cf):?>
       				<div class="slide">
       					<div class="slide-max-width">
       						<div class="slide-content-text pure-u-1 pure-u-sm-1-1 pure-u-md-1-1 pure-u-lg-9-24 pure-u-xg-8-24 box-mode p-l-md p-r-md">
       							<h2 class="title ghost"><?=$cf['nome']?></h2>
       							<p class="paragraph ghost"><?=$cf['texto']?></p>
       			
       							<a href="javascript:void(0)" data-modal-btn="schedule-conversation" class="btn secondary ghost"><?=$cabecalho_agende_uma_conversa?></a>							
    								
    							<img class="notebook-cellphone-floating animation-doYouWantABaloon pennywise" src="/images/notebook-cellphone.webp" aria-hidden="true" alt="notebook">	
    						</div>				
    						<!-- <div class="slide-content-image">
    							<img class="slide-full-image pure-img" src="<?=ENDERECO?>admin/files/como_funciona/<?=$cf['imagem']?>" alt="<?=$cf['nome']?>" aria-hidden="true">
    						</div> -->
       					</div>
       				</div>
                <?php endforeach;?>
    			</div>
    			<div class="slide-content-image">
    				<img class="slide-full-image pure-img" src="<?=ENDERECO?>admin/files/como_funciona/<?=$cf['imagem']?>" alt="<?=$cf['nome']?>" aria-hidden="true">
    			</div>
    		</div>
    	
    		<div class="page-media width-100 box-mode p-t-xl">
    			<img data-sal="slide-up" id="three-notebooks" class="width-max-1334 layout-center" src="/images/banner-notebooks.webp" alt="notebooks">			
    			<div class="bg-gray-100 banner-corner-round"></div>	
    		</div>
    		<div class="layout-max-width text center">
    			<ul class="list-checked">
    				<li data-sal="zoom-out">
    					2G - 3G - 4G <br> Wi-fi & Bluetooth
    				</li>
    				<li data-sal="flip-left" style="--sal-delay:.5;">
    					<?=$home_telemetria?>
    				</li>
    				<li data-sal="flip-left" style="--sal-delay:.5;">
    					Hotspot
    				</li>
    				<li data-sal="flip-left" style="--sal-delay:.5;">
    					<?=$home_gps?>
    				</li>
    				<li data-sal="flip-left" style="--sal-delay:.5;">
    					<?=$home_plug_play?>
    				</li>
    				<li>
    					<?=$home_bateria_interna?>
    				</li>
    			</ul>
    	
    			<a href="javascript:void(0)" data-sal="zoom-in" data-modal-btn="schedule-conversation" class="btn primary ghost"><?=$cabecalho_agende_uma_conversa?></a>	
    		</div>
    	</section>
    <?php endif;?>
	
	<!--###################
		SECTION: BLOG
	####################-->
    <?php if(!empty($vantagens)):?>
    	<section class="page-stripe pure-g">
    		<div class="layout-max-width">
    			<h1 data-sal="slide-left" class="title text right bottom-line box-mode m-t-lg m-b-lg"><?=$blog_ultimas_do_blog?></h1>
    	
    			<div class="flex-wrap flex-container flex-direction-row flex-stretch-start">
                <?php foreach ($maisRecentes as $key => $mr):?>
       				<div data-sal="zoom-out" class="shadow card">
       					<div class="card-header-image-wrapper">
       						<img class="header-image" src="<?=ENDERECO?>admin/files/blog/thumb_<?=$mr['imagem']?>" alt="<?=$mr['nome']?>">
       					</div>
       					<div class="card-body">
       						<h1 class="title small"><?=$mr['nome']?></h1>
       						<p class="paragraph line-clamp clamp--3"><?=$mr['resumo']?></p>
       						<a href="<?=ENDERECO_IDIOMA?>blog/<?=$mr['urlrewrite']?>" class="btn primary ghost"><?=$blog_continue_lendo?> &gt;&gt;</a>
       					</div>
       				</div>
                <?php endforeach;?>
    			</div>			
    		</div>
    	</section>
    <?php endif;?>

	<?php include_once("includes/modais.php");?>
	<?php include_once("includes/floating_vertical_bar.php");?>
</main>