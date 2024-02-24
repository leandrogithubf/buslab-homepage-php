<?php include 'includes/topo.php';?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php print $seo['title']; ?></title>
    <meta name="author" content="<?php print $head['author']; ?>" />
    <meta name="description" content="<?php print $seo['description']; ?>" />
    <meta name="keywords" content="<?php print $seo['keywords']; ?>" />
    <meta name="copyright" content="<?php print $head['copyright']; ?>" />
    <meta name="title" content="<?php print $seo['title']; ?>" />
    <meta name="robots" content="index,follow" />
    <base href="<?php print ENDERECO; ?>" property="og:title" />
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo ENDERECO.$_REQUEST['p']; ?>"/>
    <meta property="og:title" content="<?php print $seo['title']; ?>"/>
    <meta property="og:image" content="<?php print ENDERECO; ?><?php echo !empty($seo['imagem']) ? $seo['imagem'] : "images/assets/bg-logo.png"?>"/>
    <meta property="og:description" content="<?php echo ((isset($seo['resumo']))? $seo['resumo']:$seo['description']) ?>" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon-16x16.png">
    <link rel="manifest" href="./site.webmanifest">

    <!-- Pure CSS -->
    <link rel="stylesheet" href="./css/pure-min.css">
    <link rel="stylesheet" href="./css/grids-responsive-min.css">

    <!-- BusLab CSS -->
    <link rel="stylesheet" href="<?=ENDERECO?>css/build/master.css">
    <link rel="stylesheet" href="<?=ENDERECO?>css/build/import-styles.css">   

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- CSS -->
    <?php $filename = $endereco.".css";
      if(file_exists("css/build/".$filename)) { ?>
        <link rel="stylesheet" href="<?=ENDERECO?>css/build/<?php echo $endereco ?>.css">
    <?php } ?>

    <!-- Plugins -->    
    <!-- <link rel="stylesheet" href="<?=ENDERECO?>js/libs/aos/aos-min.css"> -->
    <link rel="stylesheet" href="<?=ENDERECO?>js/libs/slick/slick.css">
    <link rel="stylesheet" href="<?=ENDERECO?>js/libs/slick/slick-theme.css">
    <link rel="stylesheet" href="<?=ENDERECO?>css/slick-theme@extended.css">
    <link rel="stylesheet" href="<?=ENDERECO?>js/libs/customScrollbar/jquery.mCustomScrollbar.css">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="<?=ENDERECO?>js/libs/horizontalTimeline/css/style.css">
    <link rel="stylesheet" href="<?=ENDERECO?>js/libs/blackTabs/blackTabs.min.css">
    <link rel="stylesheet" type="text/css" href="<?=ENDERECO?>js/libs/fancyBoxLoading/source/jquery.fancybox.css" media="screen" property="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="<?=ENDERECO?>js/libs/jnotify/jquery/jNotify.jquery.css" property="stylesheet" media="screen" />
    <link type="text/css" rel="stylesheet" href="<?=ENDERECO?>js/libs/sal/sal.css" property="stylesheet" media="screen">

    <?php include 'seo/analytics.php'; ?>
  </head>
  <body>
