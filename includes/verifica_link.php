<?php

   include_once __DIR__.'/../admin/includes/functions.php';
   include_once __DIR__.'/../admin/blog_post_class.php';
   include_once __DIR__.'/../admin/blog_categoria_class.php';
   include_once __DIR__.'/../admin/blog_comentarios_class.php';
   include_once __DIR__.'/../admin/timeline_class.php';
   include_once __DIR__.'/../admin/vantagens_class.php';
   include_once __DIR__.'/../admin/solucoes_class.php';
   include_once __DIR__.'/../admin/clientes_class.php';
   include_once __DIR__.'/../admin/atuacao_class.php';
   include_once __DIR__.'/../admin/features_class.php';
   include_once __DIR__.'/../admin/depoimento_class.php';
   include_once __DIR__.'/../admin/banner_class.php';
   include_once __DIR__.'/../admin/como_funciona_class.php';

   $MODULO = strtolower($MODULO);

   $blog_filtros = traduzir($_SESSION['IDIDIOMA'], 'blog_filtros');
   $blog_pesquise_aqui = traduzir($_SESSION['IDIDIOMA'], 'blog_pesquise_aqui');
   $blog_categorias = traduzir($_SESSION['IDIDIOMA'], 'blog_categorias');
   $blog_mais_lidas = traduzir($_SESSION['IDIDIOMA'], 'blog_mais_lidas');
   $blog_arquivos = traduzir($_SESSION['IDIDIOMA'], 'blog_arquivos');
   $blog_cadastre_se = traduzir($_SESSION['IDIDIOMA'], 'blog_cadastre_se');
   $blog_nome = traduzir($_SESSION['IDIDIOMA'], 'blog_nome');
   $blog_email = traduzir($_SESSION['IDIDIOMA'], 'blog_email');
   $blog_cadastrar = traduzir($_SESSION['IDIDIOMA'], 'blog_cadastrar');
   $cabecalho_ja_sou_cliente = traduzir($_SESSION['IDIDIOMA'], 'cabecalho_ja_sou_cliente');
   $cabecalho_o_que_deseja_pesquisar_hoje = traduzir($_SESSION['IDIDIOMA'], 'cabecalho_o_que_deseja_pesquisar_hoje');
   $cabecalho_solucoes = traduzir($_SESSION['IDIDIOMA'], 'cabecalho_solucoes');
   $cabecalho_contato = traduzir($_SESSION['IDIDIOMA'], 'cabecalho_contato');
   $cabecalho_agende_uma_conversa = traduzir($_SESSION['IDIDIOMA'], 'cabecalho_agende_uma_conversa');
   $solucoes_conhecer_solucao_completa = traduzir($_SESSION['IDIDIOMA'], 'solucoes_conhecer_solucao_completa');
   $solucoes_solicitar_contato_agora = traduzir($_SESSION['IDIDIOMA'], 'solucoes_solicitar_contato_agora');
   $solucoes_agende_uma_conversa_agora = traduzir($_SESSION['IDIDIOMA'], 'solucoes_agende_uma_conversa_agora');
   $solucoes_empresa = traduzir($_SESSION['IDIDIOMA'], 'solucoes_empresa');
   $solucoes_telefone = traduzir($_SESSION['IDIDIOMA'], 'solucoes_telefone');
   $rodape_trabalhe_conosco = traduzir($_SESSION['IDIDIOMA'], 'rodape_trabalhe_conosco');
   $rodape_menu = traduzir($_SESSION['IDIDIOMA'], 'rodape_menu');
   $rodape_cadastrar_email = traduzir($_SESSION['IDIDIOMA'], 'rodape_cadastrar_email');
   $rodape_todos_os_direitos_reservados = traduzir($_SESSION['IDIDIOMA'], 'rodape_todos_os_direitos_reservados');
   $rodape_desenvolvido_por = traduzir($_SESSION['IDIDIOMA'], 'rodape_desenvolvido_por');
   $blog_comentarios = traduzir($_SESSION['IDIDIOMA'], 'blog_comentarios');
   $blog_escreva_aqui_seu_comentario = traduzir($_SESSION['IDIDIOMA'], 'blog_escreva_aqui_seu_comentario');
   $blog_enviar_comentario = traduzir($_SESSION['IDIDIOMA'], 'blog_enviar_comentario');
   $blog_ultimas_do_blog = traduzir($_SESSION['IDIDIOMA'], 'blog_ultimas_do_blog');
   $blog_continue_lendo = traduzir($_SESSION['IDIDIOMA'], 'blog_continue_lendo');
   $blog_compartilhe = traduzir($_SESSION['IDIDIOMA'], 'blog_compartilhe');
   $blog_categoria = traduzir($_SESSION['IDIDIOMA'], 'blog_categoria');
   $blog_leia_mais = traduzir($_SESSION['IDIDIOMA'], 'blog_leia_mais');
   $blog_por_autor = traduzir($_SESSION['IDIDIOMA'], 'blog_por_autor');
   $buslab_mas_o_que_exatamente_e = traduzir($_SESSION['IDIDIOMA'], 'buslab_mas_o_que_exatamente_e');
   $buslab_mas_o_que_exatamente_e_texto = traduzir($_SESSION['IDIDIOMA'], 'buslab_mas_o_que_exatamente_e_texto');
   $buslab_missao = traduzir($_SESSION['IDIDIOMA'], 'buslab_missao');
   $buslab_visao = traduzir($_SESSION['IDIDIOMA'], 'buslab_visao');
   $buslab_valores = traduzir($_SESSION['IDIDIOMA'], 'buslab_valores');
   $buslab_missao_texto = traduzir($_SESSION['IDIDIOMA'], 'buslab_missao_texto');
   $buslab_visao_texto = traduzir($_SESSION['IDIDIOMA'], 'buslab_visao_texto');
   $buslab_valores_texto = traduzir($_SESSION['IDIDIOMA'], 'buslab_valores_texto');
   $buslab_historia = traduzir($_SESSION['IDIDIOMA'], 'buslab_historia');
   $buslab_conheca_nossas_solucoes = traduzir($_SESSION['IDIDIOMA'], 'buslab_conheca_nossas_solucoes');
   $buslab_conhecer_agora = traduzir($_SESSION['IDIDIOMA'], 'buslab_conhecer_agora');
   $buslab_nossas_vantagens = traduzir($_SESSION['IDIDIOMA'], 'buslab_nossas_vantagens');
   $contato_fale_conosco = traduzir($_SESSION['IDIDIOMA'], 'contato_fale_conosco');
   $contato_contato_comercial = traduzir($_SESSION['IDIDIOMA'], 'contato_contato_comercial');
   $contato_ja_sou_cliente = traduzir($_SESSION['IDIDIOMA'], 'contato_ja_sou_cliente');
   $contato_enviar_mensagem_agora = traduzir($_SESSION['IDIDIOMA'], 'contato_enviar_mensagem_agora');
   $contato_mensagem = traduzir($_SESSION['IDIDIOMA'], 'contato_mensagem');
   $contato_contatos = traduzir($_SESSION['IDIDIOMA'], 'contato_contatos');
   $contato_anexo_curriculo = traduzir($_SESSION['IDIDIOMA'], 'contato_anexo_curriculo');
   $home_conheca_a_buslab = traduzir($_SESSION['IDIDIOMA'], 'home_conheca_a_buslab');
   $home_saiba_mais = traduzir($_SESSION['IDIDIOMA'], 'home_saiba_mais');
   $home_nossas_vantagens = traduzir($_SESSION['IDIDIOMA'], 'home_nossas_vantagens');
   $home_como_funciona = traduzir($_SESSION['IDIDIOMA'], 'home_como_funciona');
   $home_telemetria = traduzir($_SESSION['IDIDIOMA'], 'home_telemetria');
   $home_gps = traduzir($_SESSION['IDIDIOMA'], 'home_gps');
   $home_plug_play = traduzir($_SESSION['IDIDIOMA'], 'home_plug_play');
   $home_bateria_interna = traduzir($_SESSION['IDIDIOMA'], 'home_bateria_interna');
   $solucoes_agendar_conversa_agora = traduzir($_SESSION['IDIDIOMA'], 'solucoes_agendar_conversa_agora');
   $solucoes_alta_performance = traduzir($_SESSION['IDIDIOMA'], 'solucoes_alta_performance');
   $solucoes_alta_performance_texto = traduzir($_SESSION['IDIDIOMA'], 'solucoes_alta_performance_texto');
   $solucoes_confira_outras_solucoes = traduzir($_SESSION['IDIDIOMA'], 'solucoes_confira_outras_solucoes');
   $alerta_1 = traduzir($_SESSION['IDIDIOMA'], 'alerta_1');
   $alerta_2 = traduzir($_SESSION['IDIDIOMA'], 'alerta_2');
   $alerta_3 = traduzir($_SESSION['IDIDIOMA'], 'alerta_3');
   $alerta_4 = traduzir($_SESSION['IDIDIOMA'], 'alerta_4');
   $alerta_5 = traduzir($_SESSION['IDIDIOMA'], 'alerta_5');
   $sucesso_1 = traduzir($_SESSION['IDIDIOMA'], 'sucesso_1');
   $sucesso_2 = traduzir($_SESSION['IDIDIOMA'], 'sucesso_2');
   $sucesso_3 = traduzir($_SESSION['IDIDIOMA'], 'sucesso_3');

   if (empty($MODULO) || $MODULO == 'home'){
   	$MODULO = 'home';
      $banner = buscaBanner(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>1,'ordem'=>'ordem','dir'=>'asc'));
      $comofunciona = buscaComo_funciona(array('ididiomas'=>$_SESSION['IDIDIOMA'],'ordem'=>'ordem','dir'=>'asc'));
      $maisRecentes = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>'1', 'ordem'=>'data_hora', 'dir'=>'desc', 'limit'=>3));
      $vantagens = buscaVantagens(array('ididiomas'=>$_SESSION['IDIDIOMA'],'ordem'=>'ordem', 'dir'=>'asc'));
      foreach($vantagens as $key => $v){
         if(strlen($vantagens[$key]['icone']) < 4){
            $vantagens[$key]['icone'] = buscaFW3(array("idfw"=>$v['icone']));
         }else{
           $vantagens[$key]['icone'] = array(array("idfw" => 0,"nome" => $vantagens[$key]['icone']));
         }
      }
   }
   elseif($MODULO == 'buslab'){
      $timeline = buscaTimeline(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>1,'ordem'=>'ano','dir'=>'asc'));
      $vantagens = buscaVantagens(array('ididiomas'=>$_SESSION['IDIDIOMA'],'ordem'=>'ordem', 'dir'=>'asc'));
      foreach($vantagens as $key => $v){
         if(strlen($vantagens[$key]['icone']) < 4){
            $vantagens[$key]['icone'] = buscaFW3(array("idfw"=>$v['icone']));
         }else{
           $vantagens[$key]['icone'] = array(array("idfw" => 0,"nome" => $vantagens[$key]['icone']));
         }
      }
   }
   elseif($MODULO == 'contato'){
   
   }
   elseif($MODULO == 'solucoes'){
      $solucoes = buscaSolucoes(array('ididiomas'=>$_SESSION['IDIDIOMA']));
      foreach($solucoes as $key1 => $v){
         $solucoes[$key1]['diferenciais'] = buscaRecursos(array('idsolucoes'=>$v['idsolucoes']));
         foreach($solucoes[$key1]['diferenciais'] as $key => $v){
            if(strlen($solucoes[$key1]['diferenciais'][$key]['icone']) < 4){
               $solucoes[$key1]['diferenciais'][$key]['icone'] = buscaFW3(array("idfw"=>$v['icone']));
            }else{
              $solucoes[$key1]['diferenciais'][$key]['icone'] = array(array("idfw" => 0,"nome" => $solucoes[$key1]['diferenciais'][$key]['icone']));
            }
         }
      }
      foreach($solucoes as $key1 => $v){
         $solucoes[$key1]['servicos'] = buscaServicos(array('idsolucoes'=>$v['idsolucoes']));
         foreach($solucoes[$key1]['servicos'] as $key => $v){
            if(strlen($solucoes[$key1]['servicos'][$key]['icone']) < 4){
               $solucoes[$key1]['servicos'][$key]['icone'] = buscaFW3(array("idfw"=>$v['icone']));
            }else{
              $solucoes[$key1]['servicos'][$key]['icone'] = array(array("idfw" => 0,"nome" => $solucoes[$key1]['servicos'][$key]['icone']));
            }
         }
      }
      $interna = false;
      $verifica_solucao = buscaSolucoes(array('ididiomas'=>$_SESSION['IDIDIOMA'],'urlamigavel'=>$_SESSION['extra']));

      if (!empty($verifica_solucao) && !empty($_SESSION['extra'])){
         $MODULO = 'solucoes_software';
         $interna = true;
         $solucao = buscaSolucoes(array('ididiomas'=>$_SESSION['IDIDIOMA'],'urlamigavel'=>$_SESSION['extra']));
         foreach($solucao as $key1 => $v){
            $solucao[$key1]['diferenciais'] = buscaRecursos(array('idsolucoes'=>$v['idsolucoes']));
            foreach($solucao[$key1]['diferenciais'] as $key => $v){
               if(strlen($solucao[$key1]['diferenciais'][$key]['icone']) < 4){
                  $solucao[$key1]['diferenciais'][$key]['icone'] = buscaFW3(array("idfw"=>$v['icone']));
               }else{
                 $solucao[$key1]['diferenciais'][$key]['icone'] = array(array("idfw" => 0,"nome" => $solucao[$key1]['diferenciais'][$key]['icone']));
               }
            }
         }
         foreach($solucao as $key1 => $v){
            $solucao[$key1]['servicos'] = buscaServicos(array('idsolucoes'=>$v['idsolucoes']));
            foreach($solucao[$key1]['servicos'] as $key => $v){
               if(strlen($solucao[$key1]['servicos'][$key]['icone']) < 4){
                  $solucao[$key1]['servicos'][$key]['icone'] = buscaFW3(array("idfw"=>$v['icone']));
               }else{
                 $solucao[$key1]['servicos'][$key]['icone'] = array(array("idfw" => 0,"nome" => $solucao[$key1]['servicos'][$key]['icone']));
               }
            }
         }
         foreach($solucao as $key1 => $v){
            $solucao[$key1]['imagem'] = buscaImagem(array('idsolucoes'=>$v['idsolucoes']));
            foreach($solucao[$key1]['imagem'] as $key => $v){
               if(strlen($solucao[$key1]['imagem'][$key]['icone']) < 4){
                  $solucao[$key1]['imagem'][$key]['icone'] = buscaFW3(array("idfw"=>$v['icone']));
               }else{
                 $solucao[$key1]['imagem'][$key]['icone'] = array(array("idfw" => 0,"nome" => $solucao[$key1]['imagem'][$key]['icone']));
               }
            }
         }
         $p = $solucao[0];
         $outras_solucoes = buscaSolucoes(array('ididiomas'=>$_SESSION['IDIDIOMA'],'not_idsolucoes'=>$p['idsolucoes']));
         $solucoes_imagens = buscaSolucoes_imagem(array("idsolucoes"=>$p['idsolucoes'],"ordem"=>'posicao_imagem',"dir"=>'ASC'));
      }
      if(!empty($_SESSION['extra']) && is_numeric($_SESSION['extra'])){
         if($_SESSION['extra'] == 1)
         {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".ENDERECO."solucoes");
         }
         $pag = $_SESSION['extra'] - 1;
      }
   }
   elseif($MODULO == 'solucoes_hardware'){
   
   }
   // elseif($MODULO == 'cases'){
   //    $clientes = buscaClientes(array());
   //    $atuacao = buscaAtuacao(array('ordem'=>'ordem','dir'=>'asc'));
   //    $depoimento = buscaDepoimento(array('status'=>1));
   // }
   elseif($MODULO == 'blog'){
      $limit = 5;
      $pag = 0;
      $interna = false;
      $urlrewrite = "";
      $maisLidos = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>'1', 'ordem'=>'contador', 'dir'=>'desc', 'limit'=>$limit));
      $arquivos_blog = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'busca4data'=>true));
      $verifica_post = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'urlrewrite'=>$_SESSION['extra']));
      $verfica_categoria_post = buscaBlog_categoria(array('ididiomas'=>$_SESSION['IDIDIOMA'],'urlrewrite'=>$_SESSION['extra']));

      //==Subitens do Menu Blog ==//
      $categorias = buscaBlog_categoria(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status' => 1));
      $categoria_blog = buscaBlog_categoria(array('ididiomas'=>$_SESSION['IDIDIOMA'],'inner_post'=>true));
      $maisLidos = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>'1', 'ordem'=>'contador', 'dir'=>'desc', 'limit'=>$limit));
      $arquivos_blog = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'busca4data'=>true));

      $totalBlog = array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'totalRecords'=>true, 'pagina'=>$pag, 'totalRecords'=>true);

      if (!empty($verifica_post) && !empty($_SESSION['extra']) && empty($verfica_categoria_post)){
          $MODULO = 'blog-interno';
          $interna = true;
          $post = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'urlrewrite'=>$_SESSION['extra']));
          $p = $post[0];
          if(isset($p['idblog_post'])){
              $postGaleria = buscaBlog_post_imagem(array('idblog_post'=>$p['idblog_post']));
          }else{
              $postGaleria = array();
          }
          UpdateContador(array('idblog_post'=> $p['idblog_post']));
          $comen = buscaBlog_comentarios(array('idblog_post'=>$p['idblog_post'], 'status'=>2));
          $relacionados = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'limit'=>3, 'not_idblog_post'=>$p['idblog_post'], 'status'=>'1'));
          $galeria = buscaBlog_post_imagem(array('idblog_post' => $p['idblog_post']));
      }
      if(!empty($_SESSION['extra']) && is_numeric($_SESSION['extra'])){
          if($_SESSION['extra'] == 1)
          {
              header("HTTP/1.1 301 Moved Permanently");
              header("Location:".ENDERECO."blog");
          }
          $pag = $_SESSION['extra'] - 1;
      }else if($_SESSION['extra'] == 'arquivos'){
              $interna = false;
              $MODULO = 'blog';
      }
      if(!$interna){
          if(isset($_POST['busca_blog'])){
              $posts = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>'1','ordem'=>'data_hora', 'dir'=>'DESC', 'limit'=>$limit, 'nome'=>$_POST['busca_blog'], 'pagina'=>$pag));
              $totalBlog['nome'] = $_POST['busca_blog'];
              $termoBusca = $_POST['busca_blog'];
          }
          else if (!empty($_SESSION['extra']) && !empty($verfica_categoria_post)){
              $vcp =  $verfica_categoria_post[0];
              $pag = !empty($_SESSION['extra2']) ? (int)$_SESSION['extra2'] -1 : 0;
              $posts = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>'1','ordem'=>'data_hora asc', 'limit'=>$limit,'idblog_categoria'=>$vcp['idblog_categoria'], 'pagina'=>$pag));
              $totalBlog['idblog_categoria'] = $vcp['idblog_categoria'];

          }else if($_SESSION['extra'] == 'arquivos'){
              // echo '<pre>';var_dump($_SESSION['extra2']);exit;
              $pag = !empty($_SESSION['extra3']) ? (int)$_SESSION['extra3'] -1 : 0;
              $totalBlog['dataBusca'] = $_SESSION['extra2'];
              $posts = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'limit'=>$limit, 'pagina'=>$pag, 'dataBusca'=>$_SESSION['extra2']));
          }else{
              $posts = buscaBlog_post(array('ididiomas'=>$_SESSION['IDIDIOMA'],'status'=>'1','ordem'=>'data_hora', 'dir'=> 'desc', 'limit'=>$limit, 'pagina'=>$pag));
          };

          //busca total de postagens
          $totalBlog = buscaBlog_post($totalBlog);
          $totalBlog = $totalBlog[0]['totalRecords'];
          $totalPaginas = ceil($totalBlog / $limit);
          $total = $totalPaginas;
          $urlpag = ENDERECO."blog".$urlrewrite;
      }
   }
   else{
   	header("HTTP/1.1 301 Moved Permanently");
   	header("Location:".ENDERECO);
   }
