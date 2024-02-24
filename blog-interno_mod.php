<main class="box-mode m-b-4">
	<h2 style="display: none;">blog-interno</h2>
  <!--####################
      BANNER PAGE
  ####################-->
  <div class="page-banner-wrapper height flex-container flex-center-start box-mode m-b-lg">
    <div class="layout-max-width overflow-v">
    	<div class="page-banner-title-wrapper left ghost">
    	  <h1 class="title primary left">Blog</h1>
    	</div>
    </div>
    <img src="/images/page-banner-blog.webp" class="animation-zoomInOut-panView" alt="banner" aria-hidden="true">
  </div>
  <!--################
      BLOG CONTENT
    ################-->
  <section class="page-stripe pure-g">
  	<h2 style="display: none;">blog-interno</h2>
	<div class="blg-g layout-max-width flex-container flex-nowrap">
		<!-- ASIDE COLUMN -->
	  <?php include_once('includes/blog-side.php');?>
	  <!-- ARTICLE COLUMN -->
	  <div class="blog-article-column pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-4-5 pure-u-xl-4-5 box-mode flex-container flex-direction-column flex-nowrap flex-order-1">
		<!-- start article -->
		<div class="blg-article-stripe">
		  <!-- <div class="blg-article-header">
			<span class="blg-article-info tx-mediumGray"><?=$p['data_formatado']?></span>
			<div class="blg-article-info-a-r">
			  <i class="icon-sm-share icon-text-balloon text-overflow">comentários</i>
			  <span class="blg-article-ctr-comments tx-mediumGray"><?=$p['total_comentarios']?></span>
			</div>
		  </div> -->
		  <article class="blg-article">
			<h2 data-sal="slide-down" class="tx-clientBlue tx-str"><?=$p['nome']?></h2>
			<img data-sal="slide-up" src="<?=ENDERECO?>admin/files/blog/<?=$p['imagem']?>" alt="" class="pure-img box-mode bd-rds-10">
			<?=$p['descricao']?>
			<div data-sal="zoom-in" class="blg-article-images-thumbs">
            <?php foreach($galeria as $key => $g):?>
				  <img class="pure-img box-mode bd-rds-10" src="<?=ENDERECO?>admin/files/blog/<?=$g['nome_imagem']?>" alt="article">
            <?php endforeach;?>
				<!-- <img class="pure-img box-mode bd-rds-10" src="http://picsum.photos/id/1047/346/268" alt="article"> -->
			</div>
		  </article>

		  <div class="clearfix blg-article-footer">
			<div data-sal="zoom-out" class="social-container">				
				<a href="https://www.facebook.com/sharer.php?u=<?=ENDERECO?>blog/<?=$p['urlrewrite']?>" target="blank" rel="noopener noreferrer"><i class="icon icon-in-blk icon-social-sm icon-social-facebook"></i></a>
				<a href="https://web.whatsapp.com/send?text=<?=urlencode($p['nome'])?>%20%7C%20<?=ENDERECO?>blog/<?=$p['urlrewrite']?>" target="blank" rel='noreferer noopener'><i class="icon icon-in-blk icon-social-sm icon-social-whatsapp"></i></a>
				<a href="mailto:?subject=<?=urlencode($p['nome']);?>&body=<?=ENDERECO?>blog/<?=$p['urlrewrite']?>" target="blank" rel="nofollow noopener noreferer"><i class="icon icon-in-blk icon-social-sm icon-social-email"></i></a>

				<!-- <i class="icon icon-in-blk icon-social-sm icon-social-instagram"></i>                      
				<i class="icon icon-in-blk icon-social-sm icon-social-linkedin"></i> -->
			</div>	
		  </div>
		</div>
		<!-- end article -->
		<!-- start-article-comments -->
		<div>
			<p data-sal="slide-down" class="blg-article-com-ctr subtitle"><?=$p['total_comentarios']?> <?=$blog_comentarios?></p>
			<?php if(!empty($comen)):?>
				<?php foreach($comen as $key => $comentario):?>
					<div class="flex-wrap flex-container flex-direction-row flex-start-start box-mode m-b-lg">
						<div>
							<?php if(!empty($comentario['imagem'])):?>
									<img data-sal="flip-right"  class="blg-article-com-sec-avatar box-mode m-r-md" src="<?=ENDERECO?>admin/files/blog/comentarios/<?=$comentario['imagem']?>" aria-hidden="true" alt="avatar">
							<?php else:?>									
								<i data-sal="flip-right" id="icone-comentario" class="icon icon-in-blk icon-xl icon-user-circle icon-filter icone-comentario box-mode m-r-md" aria-hidden="true"></i>
								<!-- <img class="blg-article-com-sec-avatar" src="https://via.placeholder.com/84x84?text=Sem+Imagem" alt="avatar"> -->
							<?php endif;?>
						</div>
						<div data-sal="fade">
							<p class="text bold"><?=$comentario['nome']?></p>
							<p class="base-color"><?=$comentario['data_formatado']?></p>
							<p class="paragraph"><?=$comentario['comentario']?></p>
							<!-- <button class="reply-commentary shrink-75 left">Responder comentário</button> -->
						</div>
					</div>
				<?php endforeach;?>
			<?php endif;?>
			<form data-sal="slide-up" id="form-blog-comentario" class="fm-blg" method="post">
				<div class="form__group box-mode m-b-sm">
					<label for="anexar-imagem">
   					<img id="imagem-upload" style="display: none;" class="blg-article-com-sec-avatar" src="https://via.placeholder.com/64x64" alt="avatar">
   					<i id="icone-comentario" class="icon icon-in-blk icon-xl icon-user-circle icon-filter icone-comentario" aria-hidden="true"></i>
   					<input id="anexar-imagem" type="file" name="imagem" class="required" style="display: none;">
					</label>
					<input type="hidden" name="ididiomas" value="<?=$_SESSION['IDIDIOMA']?>">
               <input type="text" name="nome" class="required input-comentario" placeholder="<?=$blog_nome?>">
					<input type="text" name="email" class="required input-comentario" placeholder="<?=$blog_email?>">
				</div>
			<textarea class="required fm-i-box-blg textarea-comentario" name="comentario" placeholder="<?=$blog_escreva_aqui_seu_comentario?>"></textarea>
			<input name="idblog_post" type="hidden" value="<?=$p['idblog_post']?>">
				<button id="enviar-blog-comentario" class="btn primary shrink-75 left" type="submit"><?=$blog_enviar_comentario?></button>
			</form>
		</div>
		<!-- end-article-comments -->
	  </div>
	</div>
  </section>

  <!--###################
		SECTION: BLOG
	####################-->
	<section class="page-stripe pure-g">
		<div class="layout-max-width">
			<h2 data-sal="slide-left" class="title text right bottom-line box-mode m-b-lg"><?=$blog_ultimas_do_blog?></h2>

			<div class="flex-wrap flex-container flex-direction-row flex-stretch-start">
            <?php foreach($relacionados as $key => $rel):?>
   				<div class="shadow card">
   					<div class="card-header-image-wrapper">
   						<img class="header-image" src="<?=ENDERECO?>admin/files/blog/thumb_<?=$rel['imagem']?>" alt="">
   					</div>
   					<div data-sal="zoom-out" class="card-body">
   						<h1 class="title small"><?=$rel['nome']?></h1>
   						<p class="paragraph"><?=$rel['resumo']?></p>
   						<a href="<?=ENDERECO_IDIOMA?>blog/<?=$rel['urlrewrite']?>" class="btn primary ghost"><?=$blog_continue_lendo?> &gt;&gt;</a>
   					</div>
   				</div>
            <?php endforeach;?>
			</div>
			
		</div>
	</section>
	<?php include_once("includes/floating_vertical_bar.php");?>
</main>
