<?php
    if($_SERVER['HTTP_HOST'] == "in.agencia.red"){
        @define('ENDERECO', 'http://'.$_SERVER['HTTP_HOST'].'/buslab');
    }else{
        @define('ENDERECO', 'https://'.$_SERVER['HTTP_HOST']);
    }  
    
   include_once(__DIR__.'/../admin/solucoes_class.php');
   include_once(__DIR__.'/../admin/blog_post_class.php');
   include_once(__DIR__.'/../admin/blog_categoria_class.php');

   $paginas = array("","blog","buslab","cases","contato","solucoes"); 

   #versao do encoding xml
   $dom = new DOMDocument("1.0", "UTF-8");  
   $dom->preserveWhiteSpace = false; 
   $dom->formatOutput = true; 

   $root = $dom->createElement("urlset");
   $root->setAttribute("xmlns","http://www.sitemaps.org/schemas/sitemap/0.9");
   $root->setAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
   $root->setAttribute("xsi:schemaLocation","http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd");
    
   
   $endSite = ENDERECO; 
    
   //paginas fixas
   foreach ($paginas as $key => $value) {
      $end = $endSite;
      if(!empty($value)){
         $end .= "/pt-br/".$value;
      }
      
      $url = $dom->createElement("url");  
      $loc = $dom->createElement("loc",$end); 
      $url->appendChild($loc); 
      $root->appendChild($url);  
      $dom->appendChild($root);
   }

   //blog categorias
   $Blog_categoria = buscaBlog_categoria(array("status"=>1, 'ordem'=>'nome asc')); 
   foreach ($Blog_categoria as $key => $value) { 
      $end = $endSite;
      if(!empty($value)){
         $end .= "/".$value['url_idioma']."/blog/".$value['urlrewrite'];
      }        
      $url = $dom->createElement("url");  
      $loc = $dom->createElement("loc",$end); 
      $url->appendChild($loc); 
      $root->appendChild($url);  
      $dom->appendChild($root);
   }

   //blog
   $Blog = buscaBlog_post(array("status"=>1, 'ordem'=>'nome asc')); 
   foreach ($Blog as $key => $value) { 
      $end = $endSite;
      if(!empty($value)){
         $end .= "/".$value['url_idioma']."/blog/".$value['urlrewrite'];
      }        
      $url = $dom->createElement("url");  
      $loc = $dom->createElement("loc",$end); 
      $url->appendChild($loc); 
      $root->appendChild($url);  
      $dom->appendChild($root);
   }

   //blog
   $Solucoes = buscaSolucoes(); 
   foreach ($Solucoes as $key => $value) { 
      $end = $endSite;
      if(!empty($value)){
         $end .= "/".$value['url_idioma']."/solucoes/".$value['urlamigavel'];
      }        
      $url = $dom->createElement("url");  
      $loc = $dom->createElement("loc",$end); 
      $url->appendChild($loc); 
      $root->appendChild($url);  
      $dom->appendChild($root);
   }

   //salva o arquivo 
   $dom->save("../sitemap.xml");

   #cabeçalho da página 
   header("Content-Type: text/xml");

   # imprime o xml na tela 
   print $dom->saveXML();
?>
