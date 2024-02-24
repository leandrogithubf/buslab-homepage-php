<?php  
    setlocale(LC_TIME, 'pt_BR.utf8');

    include 'verifica.php';

    if(@!empty($MODULO) && @file_exists($MODULO.'_mod.php')){
        $endereco = $MODULO;
    }else{
        $endereco = 'home';
    }

    $seo = array(); 
    $seo['imagem'] = "images/logo.png"; 
    $seo['url'] = "";

    include 'includes/head.php';
    include (file_exists('seo/'.$endereco.'_seo.php') ? 'seo/'.$endereco.'_seo.php' : 'seo/home_seo.php');
?>