<main>
    <!--####################
        BANNER PAGE
    ####################-->
    <div class="page-banner-wrapper height flex-container flex-center-start box-mode m-b-lg">
        <div class="layout-max-width overflow-v">
            <div class="page-banner-title-wrapper left ghost">
                <h1 class="title primary left box-mode p-l-md--plus"><?=$contato_fale_conosco?></h1>
            </div>          
        </div>
        <img src="/images/page-banner-buslab.webp" class="animation-zoomInOut-panView" alt="banner" aria-hidden="true">
    </div>

    <!--######################
        SECTION: CONTATO
    ######################-->
    <section class="page-stripe pure-g">
        <h2 style="display: none;">contato</h2>
        <div class="layout-max-width">
            <div class="tabs-wrapper pure-u-1 pure-u-sm-1 pure-u-md-21-24 pure-u-lg-21-24 pure-u-xl-21-24 layout-center">
                <ul class="tabs-container">
                    <li class="blackTab"><?=$contato_contato_comercial?></li>
                    <li class="blackTab"><?=$contato_ja_sou_cliente?></li>
                    <li class="blackTab"><?=$rodape_trabalhe_conosco?></li>
                </ul>
                <div class="tabs-content-container">
                    <div class="blackTab-content">
                        <form id="form-comercial" class="text center">
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-11-24 pure-u-lg-11-24 pure-u-xl-11-24 box-mode p-r-md">
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="nome" placeholder="<?=$blog_nome?>" tabindex="1"><br>
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="telefone" placeholder="<?=$solucoes_telefone?>" tabindex="3">
                            </div>
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-11-24 pure-u-lg-11-24 pure-u-xl-11-24 box-mode">
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="email" placeholder="<?=$blog_email?>" tabindex="2"><br>
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="empresa"  placeholder="<?=$solucoes_empresa?>" tabindex="4">
                                <input type="hidden" name="ididiomas" value="<?=$_SESSION['IDIDIOMA']?>">
                            </div>
                            <button type="submit" id="enviar-comercial" class="btn primary layout-center box-mode m-b-lg" tabindex="5"><?=$contato_enviar_mensagem_agora?></button>
                        </form>
                    </div>
                    <div class="blackTab-content">
                        <form id="form-cliente" class="text center">
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-11-24 pure-u-lg-11-24 pure-u-xl-11-24 box-mode p-r-md">
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="nome" placeholder="<?=$blog_nome?>" tabindex="1"><br>
                                <input class="form-input width-100 box-mode m-b-md required telefone" type="text" name="telefone"  placeholder="<?=$solucoes_telefone?>" tabindex="3">
                            </div>
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-11-24 pure-u-lg-11-24 pure-u-xl-11-24 box-mode">
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="email"  placeholder="<?=$blog_email?>" tabindex="2"><br>
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="empresa"  placeholder="<?=$solucoes_empresa?>" tabindex="4">
                                <input type="hidden" name="ididiomas" value="<?=$_SESSION['IDIDIOMA']?>">
                            </div>
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-22-24 pure-u-lg-22-24 pure-u-xl-22-24 box-mode">
                                <textarea class="form-input width-100 box-mode m-b-md required" name="mensagem"  cols="30" rows="10" placeholder="<?=$contato_mensagem?>" tabindex="5"></textarea>
                            </div>
                            <button id="enviar-cliente" type="submit" class="btn primary layout-center box-mode m-b-lg" tabindex="6"><?=$contato_enviar_mensagem_agora?></button>
                        </form>
                    </div>
                    <div class="blackTab-content">
                        <form id="form-trabalhe-conosco" class="text center">
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-11-24 pure-u-lg-11-24 pure-u-xl-11-24 box-mode p-r-md">
                                <input class="form-input width-100 box-mode m-b-md required" type="text" name="nome" id="trabalhe-nome" placeholder="<?=$blog_nome?>" tabindex="1"><br>
                                <input class="form-input width-100 box-mode m-b-md required telefone" type="tel" name="telefone" id="trabalhe-telefone" placeholder="<?=$solucoes_telefone?>" tabindex="3">
                                <input type="hidden" id="trabalhe-area" name="idarea_pretendida" value="1">
                                <input type="hidden" name="ididiomas" value="<?=$_SESSION['IDIDIOMA']?>">
                            </div>
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-11-24 pure-u-lg-11-24 pure-u-xl-11-24 box-mode">
                                <input class="form-input width-100 box-mode m-b-md required" type="email" name="email" id="trabalhe-email" placeholder="<?=$blog_email?>" tabindex="2"><br>
                                <div id="curriculo-arquivo" class="form-input blackFakeFile box-mode m-b-md">
                                    <span data-blackFakeFile-filename><?=$contato_anexo_curriculo?></span>                                    
                                    <input type="file" id="trabalhe-curriculo" class="required">
                                </div>
                            </div>
                            <div class="pure-u-1 pure-u-sm-1 pure-u-md-22-24 pure-u-lg-22-24 pure-u-xl-22-24 box-mode">
                                <textarea class="form-input width-100 box-mode m-b-md required" name="mensagem"  cols="30" rows="10" placeholder="<?=$contato_mensagem?>" tabindex="5"></textarea>
                            </div>
                            <button id="enviar-trabalhe-conosco" type="submit" class="btn primary layout-center box-mode m-b-lg" tabindex="5"><?=$contato_enviar_mensagem_agora?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex-container flex-direction-row flex-wrap flex-justify-center offset-y-negative-lg box-mode m-0">
                <div class="pure-u-1 pure-sm-1 pure-u-md-6-24 pure-u-lg-6-24 pure-u-xl-6-24 box-mode p-md border thin solid gray-200 bd-rds-sm bg-white">
                    <p class="subtitle"><?=$contato_contatos?></p>
                    <div class="box-mode m-b-md gray-300">
                        <div class="flex-container flex-direction-row flex-nowrap">
                            <i class="icon icon-in-blk icon-sm box-mode m-r-md icon-pin" aria-hidden="true"></i>
                            <p class="text small box-mode m-b-md"><a href="https://goo.gl/maps/faFXhGu3EWAPnuDF8" target="_blank" class="prevent-default">Av. Brigadeiro Luís Antônio, 3530 - Conj. 61 - Jd. Paulista, São Paulo SP</a></p>
                        </div>
                        <p class="text small box-mode m-b-md"><i class="icon icon-in-blk icon-sm box-mode m-r-md icon-phone" aria-hidden="true"></i><a href="tel:+55-11-3051-6731" class="prevent-default">(11)&nbsp;3051-6731</a></p>
                        <p class="text small box-mode m-b-md"><i class="icon icon-in-blk icon-sm box-mode m-r-md icon-social-whatsapp" aria-hidden="true"></i><a href="tel:+55-11-99999-9999" class="prevent-default">(11)&nbsp;9&nbsp;9999-9999</a></p>
                        <p class="text small box-mode m-b-md"><i class="icon icon-in-blk icon-sm box-mode m-r-md icon-social-email" aria-hidden="true"></i><a href="mailto:contato@buslab.com.br" class="prevent-default">contato@buslab.com.br</a></p>
                    </div>
                    <div class="social-container">
						<i class="icon icon-in-blk icon-sm icon-social-instagram"><a href="instagram.com" aria-label="instagram"></a></i>
						<i class="icon icon-in-blk icon-sm icon-social-facebook"><a href="facebook.com" aria-label="facebook"></a></i>
						<i class="icon icon-in-blk icon-sm icon-social-linkedin"><a href="linkedin.com" aria-label="linkedin"></a></i>
					</div>
                </div>
                <div class="pure-u-1 pure-u-sm-12-24 pure-u-md-12-24 pure-u-lg-12-24 pure-u-xl-12-24 box-mode border thin solid gray-200 bd-rds-sm overflow-h">
                    <div class="mapouter"><div class="gmap_canvas"><iframe width="553" height="315" id="gmap_canvas" src="https://maps.google.com/maps?q=3530,%20Av.%20Brigadeiro%20Lu%C3%ADs%20Ant%C3%B4nio&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe><a href="https://soap2day-to.com">soap2day</a><br><!-- <style>.mapouter{position:relative;text-align:right;height:315px;width:553px;}</style> --><a href="https://www.embedgooglemap.net">embed map google</a><!-- <style>.gmap_canvas {overflow:hidden;background:none!important;height:315px;width:553px;}</style> --></div></div>
                </div>
            </div>
        </div>
    </section>
    <?php include_once("includes/modais.php");?>
    <?php include_once("includes/floating_vertical_bar.php");?>
</main>