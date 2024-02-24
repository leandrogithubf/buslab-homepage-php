<main>
	<!--####################
		BANNER PAGE
	####################-->
	<div class="page-banner-wrapper height flex-container flex-center-start box-mode m-b-lg">
		<div class="layout-max-width overflow-v">
			<div class="page-banner-title-wrapper left ghost">
				<h1 class="title primary left">BusLab</h1>
			</div>			
		</div>
		<img src="/images/page-banner-buslab.webp" class="animation-zoomInOut-panView" alt="banner" aria-hidden="true">
	</div>
	
	<!--######################
		SECTION:QUEM SOMOS
	######################-->
	<section class="page-stripe pure-g flex-container flex-direction-column flex-nowrap box-mode m-b-lg">
		<div class="layout-max-width flex-container flex-direction-row flex-wrap flex-align-end box-mode m-b-lg">
			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1-2 pure-u-lg-14-24 flex-order-1 box-mode m-t-lg bd-rds-sm overflow-h">
				<div data-sal="slide-right" class="page-media-yt flex-container">
					<!--
						youtube embed param
							560 x 417
					 
					 <iframe width="560" height="417" src="https://www.youtube.com/embed/gojq0-jkqDU?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
						<img src="./images/shutterstock_1076744933.jpg" class="pure-img animation-zoomOutIn" alt="pin de loalização GPS do Google Maps em 3D vermelho">
				</div>
			</div>
			<div class="pure-u-1 pure-u-sm-1 pure-u-md-1-2 pure-u-lg-10-24 box-mode p-r-lg mob:p-r-0 flex-order-0">
				<h2 data-sal="slide-right" class="title"><?=$buslab_mas_o_que_exatamente_e?></h2>
				<p data-sal="slide-up" class="paragraph"><?=$buslab_mas_o_que_exatamente_e_texto?></p>
				<a data-sal="slide-up" href="javascript:void(0)" data-modal-btn="schedule-conversation" class="btn primary"><?=$cabecalho_agende_uma_conversa?></a>
			</div>		
		</div>
		<div id="buslab-mvv" class="flex-wrap layout-max-width flex-container flex-direction-column flex-end-start box-mode m-t-lg">
				<ul class="nav pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-1-2 pure-u-xl-1-2">
					<li data-sal="slide-up" data-sal-delay="0"><a href="javascript:void(0)" class="btn primary box-mode m-b-md" data-btn data-view="true"><?=$buslab_missao?></a></li>
					<li data-sal="slide-up" data-sal-delay="100"><a href="javascript:void(0)" class="btn primary ghost gray thin box-mode m-b-md" data-btn data-view="false"><?=$buslab_visao?></a></li>
					<li data-sal="slide-up" data-sal-delay="200"><a href="javascript:void(0)" class="btn primary ghost gray thin box-mode m-b-md" data-btn data-view="false"><?=$buslab_valores?></a></li>
				</ul>
				<div class="content pure-u-1 pure-u-sm-1 pure-u-md-1-2 pure-u-lg-1-2 pure-u-xl-1-2">
					<div data-sal="fade" class="data" data-content-view="true">
						<p class="paragraph"><?=$buslab_missao_texto?></p>					
					</div>
					<div data-sal="fade" class="data" data-content-view="false">
						<p class="paragraph"><?=$buslab_visao_texto?></p>					
					</div>
					<div data-sal="fade" class="data" data-content-view="false">
						<p class="paragraph"><?=$buslab_valores_texto?></p>					
					</div>				
				</div>
				<img data-sal="fade" id="pg-buslab-notebook-floating" class="pure-img animation-doYouWantABaloon" src="/images/notebook-open-side.webp" alt="notebook">
			</div>
	</section>
	
	<!--######################
		SECTION: TIMELINE
	######################-->
    <?php if(!empty($timeline)):?>
    	<section id="timeline-buslab" class="cd-h-timeline js-cd-h-timeline box-mode m-b-7">
    		<h2 data-sal="slide-down" class="title text center box-mode m-b-4"><?=$buslab_historia?></h2>
    		<div data-sal="slide-up" class="container cd-h-timeline__container">
    		  <div class="cd-h-timeline__dates">
    		    <div class="cd-h-timeline__line">
    		      <ol>
    	            <?php foreach($timeline as $key => $tl):?>
    		           <li data-sal-delay="200"><a href="#0" data-date="01/01/<?=$tl['ano']?>" class="cd-h-timeline__date <?=$key == 0?'cd-h-timeline__date--selected':''?>"><?=$tl['ano']?></a></li>
    	            <?php endforeach;?>
    		      </ol>
    	
    		      <span class="cd-h-timeline__filling-line" aria-hidden="true"></span>
    		    </div> <!-- .cd-h-timeline__line -->
    		  </div> <!-- .cd-h-timeline__dates -->
    		    
    		  <ul>
    		    <li><a href="#0" class="text-replace cd-h-timeline__navigation cd-h-timeline__navigation--prev cd-h-timeline__navigation--inactive" aria-label="próximo ano"></a></li>
    		    <li><a href="#0" class="text-replace cd-h-timeline__navigation cd-h-timeline__navigation--next" aria-label="ano anterior"></a></li>
    		  </ul>
    		</div> <!-- .cd-h-timeline__container -->
    	
    		<div class="cd-h-timeline__events">
    		  <ol>
    	         <?php foreach($timeline as $key => $tl):?>
    	   	    <li class="cd-h-timeline__event <?=$key==0?'cd-h-timeline__event--selected':'cd-h-timeline__event'?> text-component">
    	   	      <div class="container cd-h-timeline__event-content">
                      <?php if(!empty($tl['imagem'])):?>
    	   	      	   <figure class="timeline-content-image"><img src="<?=ENDERECO?>admin/files/timeline/<?=$tl['imagem']?>" alt=""></figure>
                      <?php endif;?>
    	   	      	<!-- <figure class="timeline-content-image"><img src="/images/business-image-01.webp" alt=""></figure> -->
    	   	        <p class="cd-h-timeline__event-description gray-300 pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-3-5 pure-u-xl-3-5"> 
    	   	          <?=$tl['texto']?>
    	   	        </p>
    	   	      </div>
    	   	    </li>
    	         <?php endforeach;?>
    		  </ol>
    		</div> <!-- .cd-h-timeline__events -->
    	</section>
    <?php endif;?>
	
	<!--####################
		PAGE BANNER
	####################-->
	<div class="page-banner-wrapper height flex-container flex-center-end box-mode m-b-lg">
		<div class="layout-max-width overflow-v flex-container flex-justify-end">
			<div data-sal="slide-left" class="page-banner-title-wrapper right primary">
				<h1 data-sal="fade" data-sal-delay="400" class="title ghost"><?=$buslab_conheca_nossas_solucoes?></h1>
				<a data-sal="flip-up" data-sal-delay="600" href="<?=ENDERECO_IDIOMA?>solucoes" class="btn small white align-start box-mode m-t-md"><?=$buslab_conhecer_agora?></a>
			</div>
		</div>
		<img class="animation-zoomInOut-panView" src="/images/page-banner-street.webp" alt="vista aérea de uma rua">
	</div>
	
	<!--############################
		SECTION: NOSSAS VANTAGENS
	############################-->
    <?php if(!empty($timeline)):?>
    	<section class="page-stripe pure-g">
    		<div class="layout-max-width">
    			<h2 data-sal="slide-right" class="title left bottom-line"><?=$buslab_nossas_vantagens?></h2>
    	
    			<div class="flex-wrap flex-container flex-direction-row flex-stretch-center">
    	         <?php foreach($vantagens as $key => $v):?>
    	   			<div data-sal="zoom-out" class="shadow card hover hover-to-reveal box-mode m-t-lg m-b-md">
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
    	   				<div class="card-body">
    	   					<p class="title"><?=$v['titulo']?></p>
    	   					<p class="paragraph"><?=$v['descricao']?></p>
    	   					<a href="javascript:void(0)" data-modal-btn="schedule-conversation" class="btn primary ghost hover-visible"><?=$cabecalho_agende_uma_conversa?></a>
    	   				</div>
    	   			</div>
    	         <?php endforeach;?>
    				<!-- <div class="shadow card hover">
    					<div class="card-header-icon">
    						<i class="icon icon-in-blk icon-advantage icon-circle-head"></i>
    					</div>
    					<div class="card-body">
    						<p class="title">Illyana Rasputin</p>
    						<p class="paragraph">Bacon ipsum dolor amet burgdoggen cow pancetta swine turkey bacon flank tenderloin. Shankle corned.</p>
    						<a href="#0" class="btn primary ghost hover-visible">Agende uma conversa</a>
    					</div>
    				</div> -->
    			</div>
    		</div>
    	</section>
    <?php endif;?>

	<?php include_once("includes/modais.php");?>
	<?php include_once("includes/floating_vertical_bar.php");?>
</main>