<footer class="page-footer pure-g">
	<div class="layout-max-width row-a">
		<div class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-1-4 pure-u-xl-1-4 box-mode mob:p-r-0 p-r-md">
			<img src="images/BusLab.svg" alt="BusLab" width="156" height="43" aria-label="BusLab" class="buslab">
			<!-- Anatel logo --> 
			<img src="images/anatel.svg" width="156" loading="lazy" decoding="async" class="box-mode m-t-md" alt="logotipo da Anatel">
			<!-- <p class="buslab-description box-mode m-t-md">Oferecemos relatórios completos, funcionais e de simples entendimento, alem de</p> -->
			
			<div id="footer-social" class="flex-container flex-start-start flex-nowrap box-mode m-t-md m-b-md">
				<div class="social-container">
					<i class="icon icon-in-blk icon-social-sm icon-social-instagram"><a href="https://www.instagram.com/buslab_control/?hl=pt-br" aria-label="instagram" target="_blank" rel="noopener noreferer"></a></i>
					<i class="icon icon-in-blk icon-social-sm icon-social-facebook"><a href="https://www.facebook.com/BusLab-465512720653938" aria-label="facebook" target="_blank" rel="noopener noreferer"></a></i>
					<i class="icon icon-in-blk icon-social-sm icon-social-linkedin"><a href="linkedin.com" aria-label="linkedin"></a></i>
				</div>
				<div class="country-container">
					<?php foreach($arrayIdiomas as $key => $idioma):?>
                  <a href="<?=ENDERECO.$idioma['urlamigavel']?>/<?=empty($_SESSION['extra'])?$_SESSION['idu']:'home'?>" aria-label="<?=$idioma['idioma']?>"><img src="<?=ENDERECO?>admin/files/idiomas/<?=$idioma['bandeira']?>" alt="imagem"></a>
               <?php endforeach;?>
				</div>					
			</div>
		</div>

		<div class="pure-u-1-2 pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-1-4 pure-u-xl-1-4 box-mode m-b-lg mob:p-l-0 p-l-lg">
			<p class="footer-title"><?=$rodape_menu?></p>
			<nav class="main-nav" aria-label="menu principal">
				<ul>
					<li><a href="<?=ENDERECO_IDIOMA?>">Home</a></li>
					<li><a href="<?=ENDERECO_IDIOMA?>buslab">BusLab</a></li>
					<li><a href="<?=ENDERECO_IDIOMA?>solucoes"><?=$cabecalho_solucoes?></a></li>
					<!-- <li><a href="<?=ENDERECO_IDIOMA?>cases">Cases</a></li> -->
					<li><a href="<?=ENDERECO_IDIOMA?>blog">Blog</a></li>
					<li><a href="<?=ENDERECO_IDIOMA?>contato"><?=$cabecalho_contato?></a></li>
					<li><a href="<?=ENDERECO_IDIOMA?>contato"><?=$rodape_trabalhe_conosco?></a></li>
				</ul>
			</nav>	
		</div>

		<div class="pure-u-1-2 pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-1-4 pure-u-xl-1-4 box-mode mob:p-l-0 p-l-md">
			<p class="footer-title"><?=$cabecalho_contato?></p>
			<address>
				<p>Av. Brigadeiro Luís Antônio, nº 3530 - Conj. 61 - Jardim Paulista, São Paulo/SP</p>
				<a href="tel:+55-11-3051-6731" class="prevent-default">+55 (11) 3051-6731</a>
			</address>
		</div>
		<div class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-2 pure-u-lg-1-4 pure-u-xl-1-4 box-mode mob:p-l-0 p-l-md m-b-md">
			<p class="footer-title">Newsletter</p>
			<form id="form-footer">
				<input type="text" class="form-input ghost required box-mode m-b-sm" name="nome" id="newsletter-name" placeholder="<?=$blog_nome?>">
				<input type="email" class="form-input ghost required box-mode m-b-sm" name="email" id="newsletter-email" placeholder="<?=$blog_email?>">
            <input type="hidden" name="ididiomas" value="1">
				<button id="enviar-footer" type="submit" class="btn white"><?=$rodape_cadastrar_email?></button>
			</form>
		</div>		
	</div>

	<div class="layout-max-width row-b">
		<p class="copyright">Copyright | <?=$rodape_todos_os_direitos_reservados?></p>
		<div class="red-seal-container">
			<span><?=$rodape_desenvolvido_por?>:</span>
			<a href="https://www.agencia.red/" target="_blank">
				<img src="images/RED-logo.svg" alt="Agência RED" aria-label="Agência RED">		
			</a>
		</div>
	</div>

   <input type="hidden" id="alerta1" value="<?=$alerta_1?>">
   <input type="hidden" id="alerta2" value="<?=$alerta_2?>">
   <input type="hidden" id="alerta3" value="<?=$alerta_3?>">
   <input type="hidden" id="alerta4" value="<?=$alerta_4?>">
   <input type="hidden" id="alerta5" value="<?=$alerta_5?>">
   <input type="hidden" id="sucesso1" value="<?=$sucesso_1?>">
   <input type="hidden" id="sucesso2" value="<?=$sucesso_2?>">
   <input type="hidden" id="sucesso3" value="<?=$sucesso_3?>">
</footer>