<header>
	<div class="topbar-wrapper width-device-100">
		<div class="layout-max-width">
			<div class="topbar-container flex-container flex-direction-row flex-wrap flex-justify-space-between ">
				<div id="social_and_country" class="flex-container flex-center-start pure-u-1 pure-u-sm-1-1 pure-u-md-1-2 pure-u-xl-1-2">
					<div class="social-container">
						<i class="icon icon-in-blk icon-social-sm icon-social-instagram"><a href="https://www.instagram.com/buslab_control/?hl=pt-br" target="_blank" rel="noopener noreferer" aria-label="instagram"></a></i>
						<i class="icon icon-in-blk icon-social-sm icon-social-facebook"><a href="https://www.facebook.com/BusLab-465512720653938" target="_blank" rel="noopener noreferer" aria-label="facebook"></a></i>
						<!-- <i class="icon icon-in-blk icon-social-sm icon-social-linkedin"><a href="linkedin.com" target="_blank" aria-label="linkedin"></a></i> -->
					</div>
					<div class="country-container">
                  <?php foreach($arrayIdiomas as $key => $idioma):?>
						   <a href="<?=ENDERECO.$idioma['urlamigavel']?>/<?=empty($_SESSION['extra'])?$_SESSION['idu']:'home'?>" aria-label="<?=$idioma['idioma']?>"><img src="<?=ENDERECO?>admin/files/idiomas/<?=$idioma['bandeira']?>" alt="imagem"></a>
                  <?php endforeach;?>
					</div>					
				</div>
				<div id="customer_and_search" class="flex-container flex-direction-row flex-nowrap pure-u-1 pure-u-sm-1-1 pure-u-md-1-2 pure-u-xl-1-2">
					<div class="contact-container">
						<span >
							<a href="tel:+55-11-3051-6731" class="prevent-default">+55 (11) 3051-6731</a>
						</span>
					</div>
					<div class="flex-container flex-direction-row flex-nowrap">
						<div class="customer-container">
							<a href="https://painel.buslab.com.br/dashboard" target="_blank" class="prevent-default btn-customer"><?=$cabecalho_ja_sou_cliente?>&nbsp;<i class="icon icon-in-blk icon-sm icon-arrow-corner-right"></i></a>
						</div>
						<div class="search-container">
							<form action="<?=ENDERECO_IDIOMA?>blog" method="get" id="form-busca">
								<div class="search-input-container" data-open="false">
									<input type="search" name="q" id="input-search" class="input-search bg-white" placeholder="<?=$cabecalho_o_que_deseja_pesquisar_hoje?>">
                           <input type="hidden" name="search" value="1">
								</div>
								<button class="btn-search" aria-label="pesquisar"></button>
							</form>
						</div>						
					</div>
				</div>
			</div>			
		</div>
	</div>

	<div class="main-nav-wrapper pure-g">
		<div class="layout-max-width">
			<div class="main-nav-container clearfix pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-1 pure-u-xl-1">
				<a href="<?=ENDERECO_IDIOMA?>"><img src="images/BusLab.svg" alt="BusLab" width="108" height="30" aria-label="BusLab" class="buslab"></a>

				<!-- <i class="only-mobile icon icon-md icon-in-blk icon-hamburguer-menu flex-container flex-align-self-center" role="button" aria-label="abrir menu" data-mobile-menu="button"></i> -->
				<div class="main-nav-mobile flex-container flex-direction-row flex-nowrap flex-align-center flex-justify-space-beteween" data-plugin="blackMobileNav" data-mobile-menu="main-nav">
					<nav class="main-nav" aria-label="menu principal">
						<ul>
							<li><a href="<?=ENDERECO_IDIOMA?>">Home</a></li>
							<li><a href="<?=ENDERECO_IDIOMA?>buslab">BusLab</a></li>
							<li><a href="<?=ENDERECO_IDIOMA?>solucoes"><?=$cabecalho_solucoes?></a></li>
							<!-- <li><a href="cases">Cases</a></li> -->
							<li><a href="<?=ENDERECO_IDIOMA?>blog">Blog</a></li>
							<li><a href="<?=ENDERECO_IDIOMA?>contato"><?=$cabecalho_contato?></a></li>
						</ul>
					</nav>
					<a href="javascript:void(0)" class="btn primary small" data-modal-btn="schedule-conversation"><?=$cabecalho_agende_uma_conversa?></a>
				</div>					
			</div>			
		</div>
	</div>
</header>