<main class="box-mode m-b-4">
  <!--####################
      BANNER PAGE
  ####################-->
  <div class="page-banner-wrapper height flex-container flex-center-start box-mode m-b-lg">
    <div class="layout-max-width overflow-v">
      <div class="page-banner-title-wrapper left ghost">
        <h1 class="title primary left">Blog</h1>
      </div>      
    </div>
    <img src="/images/page-banner-buslab.webp" class="animation-zoomInOut-panView" alt="banner" aria-hidden="true">
  </div>

  <!--################
      BLOG CONTENT
    ################-->
  <section class="page-stripe pure-g">
    <div id="blog-content" class="layout-max-width flex-container flex-nowrap">
      <!-- ASIDE COLUMN -->
      <?php include_once('includes/blog-side.php');?>    
      <h2 style="display: none;">blog</h2>  
      <!-- <p id="blog-descricao"></p> -->
      <!-- ARTICLE COLUMN -->
      <div class="blog-article-column pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-4-5 pure-u-xl-4-5 box-mode flex-container flex-direction-column flex-nowrap flex-order-1">
          <div class="gcse-searchresults-only" data-lr="lang_pt"></div>
          <div id="blog-artigos">
            <?php foreach($posts as $key => $p):?>
              <!-- start article -->
              <div class="blg-article-stripe">
                <div data-sal="fade" class="blg-article-header">
                  <i class="icon icon-md icon-in-blk icon-comments" role="button" aria-label="comentários"></i>
                  <span class="blg-article-ctr-comments"><?=$p['total_comentarios']?></span>


                  <div class="social-container">
                    <span><?=$blog_compartilhe?>:</span>
                    <a href="https://www.facebook.com/sharer.php?u=<?=ENDERECO?>blog/<?=$p['urlrewrite']?>" target="blank" rel="noopener noreferrer"><i class="icon icon-in-blk icon-social-sm icon-social-facebook"></i></a>
                      <!-- <i class="icon icon-in-blk icon-social-sm icon-social-instagram"></i>                      
                      <i class="icon icon-in-blk icon-social-sm icon-social-linkedin"></i> -->
                  </div>

                  <p class="blg-article-ctr-category"><?=$blog_categoria?>:&nbsp;<?=$p['nome_categoria']?></p>
                </div>
                <article class="blg-article">
                  <img data-sal="zoom-in" src="<?=ENDERECO?>admin/files/blog/thumb_<?=$p['imagem']?>" alt="" class="blg-article-thumb-img">
                  <div class="blg-article-content">
                    <h2 data-sal="slide-up" ><?=$p['nome']?></h2>
                    <p data-sal="fade"><?=$p['resumo']?></p>
                    <div data-sal="flip-up"><a href="<?=ENDERECO_IDIOMA?>blog/<?=$p['urlrewrite']?>" class="btn primary shrink-75 left"><?=$blog_leia_mais?>&nbsp;&nbsp;<i class="icon icon-md icon-in-blk icon-arrow icon-filter ghost right"></i></a></div>
                  </div>
                </article>
                <div data-sal="fade" class="clearfix blg-article-footer">
                  <ul class="blg-article-info">
                    <li class="blg-article-info-item"><?=$blog_por_autor?> <?=$p['autor']?>&nbsp;</li>
                    <li class="blg-article-info-item"><?=$p['data_formatado']?></li>
                  </ul>                    
                </div>
              </div>
              <!-- end article -->
            <?php endforeach;?>
          </div>
        <!-- article pagination -->
        <!-- <div class="blg-pag">
          <ul class="blg-pag-list">
            <li class="blg-pag-list-nav"><a href="#" class="blg-pag-list-nav-prev" aria-label="voltar paginação" data-actived="off"></a></li>
            <li class="blg-pag-list-item"><a href="#" class="blg-pag-list-num" data-actived="on">1</a></li>
            <li class="blg-pag-list-item"><a href="#" class="blg-pag-list-num">2</a></li>
            <li class="blg-pag-list-item"><a href="#" class="blg-pag-list-num">3</a></li>
            <li class="blg-pag-list-item"><a href="#" class="blg-pag-list-num">4</a></li>
            <li class="blg-pag-list-item"><a href="#" class="blg-pag-list-num">5</a></li>
            <li class="blg-pag-list-item"><a href="#" class="blg-pag-list-num">6</a></li>
            <li class="blg-pag-list-item"><a href="#" class="blg-pag-list-num">7</a></li>
            <li class="blg-pag-list-nav"><a href="#" class="blg-pag-list-nav-next" aria-label="avançar paginação" data-actived="on"></a></li>
          </ul>
        </div> -->
        <?php include_once("includes/paginacao.php");?>
      </div>    
    </div>

  </section>
  <?php include_once("includes/modais.php");?>
  <?php include_once("includes/floating_vertical_bar.php");?>
</main>
