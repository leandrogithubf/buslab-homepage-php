<main>
	<!--####################
		BANNER PAGE
	####################-->
	<div class="page-banner-wrapper height flex-container flex-center-start box-mode m-b-md">
		<div class="layout-max-width overflow-v">
			<div class="page-banner-title-wrapper left ghost">
				<h1 class="title primary left"><?=$cabecalho_solucoes?></h1>
			</div>			
		</div>
		<img src="/images/page-banner-buslab.webp" class="animation-zoomInOut-panView" alt="banner" aria-hidden="true">
	</div>
	
	<!--######################
		SECTION: SOLUÇÕES
	######################-->
	<div class="page-stripe">
		<div class="layout-max-width">
			<div class="flex-wrap flex-container flex-direction-row flex-stretch-center box-mode m-t-lg">
	         <?php foreach($solucoes as $key => $s):?>
	   			<div data-sal="flip-left" class="card hover hover-to-reveal full-image filter base">
	   				<div class="card-body">
	   					<p class="title ghost box-mode m-0"><?=$s['titulo']?></p>
	   					<a href="javascript:void(0)" class="btn ghost hover-visible box-mode m-t-sm" data-modal-btn="solutions-<?=$s['urlamigavel']?>"><?=$home_saiba_mais?> >></a>
	   				</div>
	   				<img src="<?=ENDERECO?>admin/files/solucoes/<?=$s['thumbs']?>" alt="tecnologia">
	   			</div>
	         <?php endforeach;?>
				<!-- <div class="card hover hover-to-reveal full-image filter base">
					<div class="card-body">
						<p class="title ghost">Software</p>
						<a href="javascript:void(0)" class="btn ghost hover-visible box-mode m-t-1" data-modal-btn="solutions-software">saiba mais >></a>
					</div>
					<img src="/images/card-image-software.webp" alt="software">
				</div> -->
			</div>
		</div>
	</div>
	
	<?php include_once("includes/modais.php");?>
	<?php include_once("includes/floating_vertical_bar.php");?>
</main>