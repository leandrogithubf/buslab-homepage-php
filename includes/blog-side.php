<aside id="blog-side" class="pure-u-1 pure-u-sm-1 pure-u-md-1 pure-u-lg-1-5 pure-u-xl-1-5 flex-container flex-direction-column flex-nowrap flex-order-2">
  <div class="blog-filter-mobile pure-u-1 flex-container flex-direction-row flex-nowrap flex-justify-end box-mode m-b-lg">
    <span class="text small gray-400 box-mode m-r-sm"><?=$blog_filtros?></span>
    <a href="javascript:void(0)" class="icon icon-sm--minus icon-in-blk icon-filter-mob" data-blog-filter aria-label="filtros" tabindex="0"></a>
  </div>

  <div class="blog-side-mobile">
   <!-- form search blog -->
   <form id="form-busca-2" class="fm fm-blg box-mode m-b-md" action="<?=ENDERECO_IDIOMA?>blog" method="get">
     <div class="fm-i-w-btn">
       <input type="text" name="q" id="input-buscar" placeholder="<?=$blog_pesquise_aqui?>" class="required fm-i-box-blg">
       <input type="hidden" name="search" value="1">
       <input type="submit" value="Pesquisar" class="btn-search fm-blg-i-i-btn icon-magnifier">
     </div>
   </form>
   
    <?php
       $searchGoogle = strstr($_SERVER['REQUEST_URI'], "search=");
       if(!empty($searchGoogle)):
          $searchGoogle = strstr($searchGoogle, "=");
          $searchGoogle = str_replace("=", "", $searchGoogle);
          if(!empty($searchGoogle) && ($searchGoogle == "1") || $searchGoogle == "2"):
    ?>
          <input type="hidden" id="procurar-ativo" value="<?=$searchGoogle?>">
    <?php
          endif;
       endif;
    ?>
   
   <!-- CATEGORIAS -->
   <ul class="v-link-list box-mode m-b-md">
     <li class="v-link-list-title"><?=$blog_categorias?></li>
     <?php foreach ($categoria_blog as $key => $categoria): ?>
       <li class="v-link-list-item"><a href="<?=ENDERECO_IDIOMA?>blog/<?=$categoria['urlrewrite']?>" class="v-link-list-link"><?=$categoria['nome']?></a></li>
     <?php endforeach;?>
   </ul>
   <!-- MAIS LIDAS -->
   <dl class="v-link-list list-def box-mode m-b-md">
     <dt class="v-link-list-title"><?=$blog_mais_lidas?></dt>
     <?php foreach ($maisLidos as $key => $mais_lido): ?>
        <dt class="v-link-list-subtitle"><a href="<?=ENDERECO_IDIOMA?>blog/<?=$mais_lido['urlrewrite']?>" class="v-link-list-link"><?=$mais_lido['nome']?></a></dt>
        <dd class="v-link-list-item"><?=$mais_lido['dia_']?> de <?=utf8_decode($mais_lido['mes_form'])?> de <?=$mais_lido['ano_']?></dd>
     <?php endforeach;?>
   </dl>
   <!-- ARQUIVOS -->
   <ul class="v-link-list box-mode m-b-md">
     <li class="v-link-list-title"><?=$blog_arquivos?></li>
     <?php foreach ($arquivos_blog as $key => $arquivo): ?>
       <li class="v-link-list-item"><a href="<?=ENDERECO_IDIOMA?>blog/arquivos/<?=$arquivo['ano_']?>-<?=$arquivo['mes_']?>" class="v-link-list-link"><?=utf8_decode($arquivo['mes_form'])?> <?=$arquivo['ano_']?> (<?=$arquivo['qtd_post']?>)</a></li>
     <?php endforeach;?>
   </ul>
   <!-- NEWSLETTER -->
   <div class="newsletter-box box-mode m-b-md">
     <p class="newsletter-title"><?=$blog_cadastre_se?></p>
     <form class="fm-newsletter" id="form-newsletter" method="post">
       <input type="text" class="fm-newsletter-i required" name="nome" id="news-user-name" placeholder="<?=$blog_nome?>">
       <input type="text" class="fm-newsletter-i required" name="email" id="news-user-email" placeholder="<?=$blog_email?>">
       <input type="hidden" name="ididiomas" value="1">
       <button id="enviar-newsletter" class="btn primary shrink-75"><?=$blog_cadastrar?>&nbsp;&nbsp;<i class="icon icon-md icon-in-blk icon-arrow icon-filter ghost right"></i></button>
     </form>
   </div>
  </div>
</aside>