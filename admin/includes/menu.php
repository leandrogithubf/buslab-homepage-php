<aside class="menu bg <?=(!isset($_SESSION['lateral']) ? "open" : $_SESSION['lateral'] );?>">
  <div class="bg_menu bg <?=(!isset($_SESSION['lateral']) || $_SESSION['lateral'] == "open" ? "" : 'close' );?>"></div>
  <h1 class="menu_logo"><a href="<?=ENDERECO?>" class="menu_logo_a">
    <img src="images/cliente/logo.png"  width="143" alt="ico" />
    <img class="logo_close" src="images/cliente/logo_small.png" height="39" width="30" alt="ico" />
  </a></h1>
  <h2 class="menu_tit">Sistema de Gestão Web</h2>
  <div class="menu_bts">
    <div class="menu_bts_inner">
      <a href="http://www.agencia.red/contact" class="menu_bts_li" target="_blank"><img src="images/doubt.png" height="30" width="55" alt="ico" /></a>
      <a href="?mod=usuario&acao=formUsuario&met=editaUsuario&idu=<?=$_SESSION['sgc_idusuario'];?>" class="menu_bts_li"><img src="images/key.png" height="30" width="55" alt="ico" /></a>
      <a href="" id="logoffBtn" class="menu_bts_li"><img src="images/off.png" height="30" width="55" alt="ico" /></a>
      
      <!-- ADD ICON MENU -->

      <a href='#' id='mobHambBtn' onclick="showMenuMob(this)" class='menu_bts_li'><img src='css/menumob.png' height='30' width='55' alt='ico'></a>
      <script>
        function showMenuMob() {
          $(".menu_ul, .menu_user, .menu_sec").fadeToggle();

        }
      </script>

      <!-- STOP ICON MENU -->


    </div>
  </div>
  <div class="menu_user">
    <div class="menu_user_inner">
      <img src="<?= !empty($_SESSION['sgc_foto'])? "files/images/thumbs2/".$_SESSION['sgc_foto'] : "http://placehold.it/36x36" ?>" alt="img" class="alteraImagem" />
      <span><?=ucwords($_SESSION['sgc_nome'])?></span>
      <ul class="huser_menu">
        <li class="huser_menu_li"><a href="?mod=usuario&acao=formUsuario&met=editaUsuario&idu=<?=$_SESSION['sgc_idusuario'];?>">Meus Dados</a></li>
        <li class="huser_menu_li"><a href="javascript:void(0)" class="alteraImagem">Alterar Foto</a></li>
        <!-- <li class="huser_menu_li"><a href="">Alterar Senha</a></li> -->
        <li class="huser_menu_li"><a href="usuario_script.php?opx=logout">Sair</a></li>
      </ul>
    </div>
  </div>
  <div class="menu_sec">
    <input type="text" class="menu_sec_ip" placeholder="Buscar" />
  </div>
  <ul class="menu_ul">
    <li class="menu_ul_li none"><a class="menu_ul_li_a" href="index.php"><img width="18" height="14" alt="ico" src="images/ico_house.png">Home</a></li>

  <?php if (verificaPermissaoAcesso('idiomas_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-globe' aria-hidden="true"></i>Idiomas</a>
      <ul>
        <li><a href="index.php?mod=idiomas&amp;acao=listarIdiomas">• Consulta</a></li>
        <li><a href="index.php?mod=idiomas&amp;acao=formIdiomas&amp;met=cadastroIdiomas">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('banner_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-picture-o' aria-hidden="true"></i>Banner</a>
      <ul>
        <li><a href="index.php?mod=banner&amp;acao=listarBanner">• Consulta</a></li>
        <li><a href="index.php?mod=banner&amp;acao=formBanner&amp;met=cadastroBanner">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('blog_post_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-rss' aria-hidden="true"></i>Blog</a>
      <ul>
        <?php if (verificaPermissaoAcesso('blog_post_visualizar', $MODULOACESSO['usuario'])) { ?>
          <li><a href="index.php?mod=blog_post&amp;acao=listarBlog_post">• Posts</a></li>
        <?php } ?>
        <?php if (verificaPermissaoAcesso('blog_categoria_visualizar', $MODULOACESSO['usuario'])) { ?>
          <li><a href="index.php?mod=blog_categoria&amp;acao=listarBlog_categoria">• Categorias</a></li>
        <?php } ?>
        <?php if (verificaPermissaoAcesso('blog_comentarios_visualizar', $MODULOACESSO['usuario'])) { ?>
          <li><a href="index.php?mod=blog_comentarios&amp;acao=listarBlog_comentarios">• Comentários</a></li>
        <?php } ?>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('contatos_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-user' aria-hidden="true"></i>Contatos</a>
      <ul>
        <li><a href="index.php?mod=contatos&amp;acao=listarContatos">• Consulta</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('como_funciona_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-info-circle' aria-hidden="true"></i>Como Funciona</a>
      <ul>
        <li><a href="index.php?mod=como_funciona&amp;acao=listarComo_funciona">• Consulta</a></li>
        <li><a href="index.php?mod=como_funciona&amp;acao=formComo_funciona&amp;met=cadastroComo_funciona">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('atuacao_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-cubes' aria-hidden="true"></i>Atuação</a>
      <ul>
        <li><a href="index.php?mod=atuacao&amp;acao=listarAtuacao">• Consulta</a></li>
        <li><a href="index.php?mod=atuacao&amp;acao=formAtuacao&amp;met=cadastroAtuacao">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('features_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-asterisk' aria-hidden="true"></i>Features</a>
      <ul>
        <li><a href="index.php?mod=features&amp;acao=listarFeatures">• Consulta</a></li>
        <li><a href="index.php?mod=features&amp;acao=formFeatures&amp;met=cadastroFeatures">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('newsletter_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-newspaper-o' aria-hidden="true"></i>Newsletter</a>
      <ul>
        <li><a href="index.php?mod=newsletter&amp;acao=listarNewsletter">• Consulta</a></li>
        <!-- <li><a href="index.php?mod=newsletter&amp;acao=formNewsletter&amp;met=cadastroNewsletter">• Cadastro</a></li> -->
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('timeline_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-hourglass' aria-hidden="true"></i>Timeline</a>
      <ul>
        <li><a href="index.php?mod=timeline&amp;acao=listarTimeline">• Consulta</a></li>
        <li><a href="index.php?mod=timeline&amp;acao=formTimeline&amp;met=cadastroTimeline">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('vantagens_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-star' aria-hidden="true"></i>Vantagens</a>
      <ul>
        <li><a href="index.php?mod=vantagens&amp;acao=listarVantagens">• Consulta</a></li>
        <li><a href="index.php?mod=vantagens&amp;acao=formVantagens&amp;met=cadastroVantagens">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('clientes_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-handshake-o' aria-hidden="true"></i>Clientes</a>
      <ul>
        <li><a href="index.php?mod=clientes&amp;acao=listarClientes">• Consulta</a></li>
        <li><a href="index.php?mod=clientes&amp;acao=formClientes&amp;met=cadastroClientes">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('depoimento_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-comment' aria-hidden="true"></i>Depoimento</a>
      <ul>
        <li><a href="index.php?mod=depoimento&amp;acao=listarDepoimento">• Consulta</a></li>
        <li><a href="index.php?mod=depoimento&amp;acao=formDepoimento&amp;met=cadastroDepoimento">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if (verificaPermissaoAcesso('solucoes_visualizar', $MODULOACESSO['usuario'])) { ?>
    <li class="menu_ul_li">
      <a class="menu_ul_li_a"><i class='fa fa-bars' aria-hidden="true"></i>Soluções</a>
      <ul>
        <li><a href="index.php?mod=solucoes&amp;acao=listarSolucoes">• Consulta</a></li>
        <li><a href="index.php?mod=solucoes&amp;acao=formSolucoes&amp;met=cadastroSolucoes">• Cadastro</a></li>
      </ul>
    </li>
  <?php } ?>

  <?php if(verificaPermissaoAcesso('trabalhe_conosco_visualizar', $MODULOACESSO['usuario']) || verificaPermissaoAcesso('area_pretendida_visualizar', $MODULOACESSO['usuario'])){ ?>
      <li class="menu_ul_li">
          <a class="menu_ul_li_a"><i class='fa fa-file-archive-o' aria-hidden="true"></i>Currículos</a>
          <ul>   
              <?php if(verificaPermissaoAcesso('area_pretendida_visualizar', $MODULOACESSO['usuario'])){ ?>
                  <li><a href="index.php?mod=area_pretendida&amp;acao=listarArea_pretendida">• Áreas</a></li> 
              <?php } ?>
              <?php if(verificaPermissaoAcesso('trabalhe_conosco_visualizar', $MODULOACESSO['usuario'])){ ?>
                  <li><a href="index.php?mod=trabalhe_conosco&amp;acao=listarTrabalhe_conosco">• Currículos</a></li>
              <?php } ?>   
          </ul>
      </li>  
   <?php } ?>

  <!-- NAO APAGAR!!! INSERIR OPCAO DE MENU AQUI -->

    <?php if(
              verificaPermissaoAcesso('configuracoes_listagem_usuarios', $MODULOACESSO['usuario']) ||
              verificaPermissaoAcesso('configuracoes_cadastro_usuarios', $MODULOACESSO['usuario']) ||
              verificaPermissaoAcesso('configuracoes_permissao', $MODULOACESSO['usuario'])         ||
              verificaPermissaoAcesso('configuracoes_log', $MODULOACESSO['usuario'])
            ){ ?>

    <li class="menu_ul_li">
        <a class="menu_ul_li_a"><img width="15" height="16" alt="ico" src="images/ico_conf.png">Configuração</a>
        <ul>
            <?php if( verificaPermissaoAcesso('configuracoes_listagem_usuarios', $MODULOACESSO['usuario']) ){ ?>
              <li><a href="index.php?mod=usuario&acao=listarUsuario">• Listagem Usuários</a></li>
            <?php } ?>
            <?php if( verificaPermissaoAcesso('configuracoes_cadastro_usuarios', $MODULOACESSO['usuario']) ){ ?>
            <li><a href="index.php?mod=usuario&acao=formUsuario&met=novaUsuario">• Cadastro Usuário</a></li>
            <?php } ?>
            <?php if( verificaPermissaoAcesso('configuracoes_permissao', $MODULOACESSO['usuario']) ){ ?>
            <li><a href="index.php?mod=permissao&acao=listarPermissao">• Permissão</a></li>
            <?php } ?>
            <?php if( verificaPermissaoAcesso('configuracoes_log', $MODULOACESSO['usuario']) ){ ?>
            <li><a href="index.php?mod=log&acao=listarLog">• Log</a></li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>

  </ul>
  <a href="" class="menu_close"></a>
</aside>
