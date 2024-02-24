<?php
	if(@extension_loaded('zlib') && !headers_sent()){
	   ob_start('ob_gzhandler');
	   header("Content-Encoding: gzip,deflate");
	}

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	include("includes/verifica.php");	
	include("includes/basic.php");
	if(isset($_GET['mod']))
		$mod = $_GET['mod'];
	else
		$mod = "home";

?>
<!DOCTYPE HTML>
<html lang="en-US">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<head>
<meta charset="UTF-8">
<title><?php print $info['tituloPagina']; ?></title>

<link rel="shortcut icon" href="images/cliente/favicon.ico" />
<link rel="shortcut icon" href="images/cliente/favicon.png" />
<link type="text/css" rel="stylesheet" href="js/jqueryuired/jquery-ui.min.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link type="text/css" rel="stylesheet" href="css/fonts.css" />
<link type="text/css" rel="stylesheet" href="css/form.css" />
<link type="text/css" rel="stylesheet" href="css/list.css" />
<link type="text/css" rel="stylesheet" href="css/timepicker.css" />
<link type="text/css" rel="stylesheet" href="js/jnotify/jquery/jNotify.jquery.css" media="screen" />
<link type="text/css" rel="stylesheet" href="js/fancyapps/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<link type="text/css" rel="stylesheet" href="js/fancyapps/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" media="screen" />
<link type="text/css" rel="stylesheet" href="js/fancyapps/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" media="screen" />
<!-- CUSTOM MOBILE -->
<link type="text/css" rel="stylesheet" href="css/custom-mobile.css" /> 

<link type="text/css" rel="stylesheet" href="css/font-awesome.min.css" media="screen" />

<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery-2.2.2.min.js"></script>
<script type="text/javascript" src="js/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.min-1.4.js"></script>
<script type="text/javascript" src="js/jnotify/jquery/jNotify.jquery.js"></script>
<script type="text/javascript" src="js/fancyapps/lib/jquery.mousewheel.pack.js"></script>
<script type="text/javascript" src="js/fancyapps/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript" src="js/fancyapps/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="js/fancyapps/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="text/javascript" src="js/fancyapps/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>

<script src="http://maps.google.com/maps/api/js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/jqueryui/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/timepicker.js"></script>
<script type="text/javascript" src="paginacao/paginacao.js"></script>

<!--SCRIPT PARA UPLOAD DOS ARQUIVOS-->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/jquery_upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery_upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery_upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery_upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery_upload/js/jquery.fileupload-image.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="js/jquery_upload/js/bootstrap.min.js"></script>


<script type="text/javascript">
     jQuery(document).ready(function(){

		jQuery('.fancybox').fancybox();
		jQuery(".money").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: false});
		jQuery(".moneyZero").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: false, allowZero: true});
		jQuery(".moneyZeroNegative").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: false, allowZero: true, allowNegative: true});
		jQuery(".percent").maskMoney({suffix:' %', thousands:'.', decimal:',', affixesStay: false});
		jQuery(".percentZero").maskMoney({suffix:' %', thousands:'.', decimal:',', affixesStay: false, allowZero: true});
		jQuery(".telefone").mask("(99)9999-9999?9",{placeholder: " "}).on("keyup", function() {
																						var elemento = $(this);
																						var valor = elemento.val().replace(/\D/g, '');
																						if (valor.length > 10) {
																							elemento.mask("(99)99999-9999",{placeholder: " "});
																						} else if (valor.length > 9) {
																							elemento.mask("(99)9999-9999?9",{placeholder: " "});
																						}
																					}).trigger('keyup');
		jQuery(".data, .wDate").mask("99/99/9999");
		jQuery(".datahora, .wDatetime").mask("99/99/9999 99:99");
		jQuery(".hora, .wTime").mask("99:99",{completed: function() {
															var elemento = $(this);
															var valor = elemento.val();
															var valor_array = valor.split(":");
															var horas = valor_array[0];
															var minutos = valor_array[1];
															if ((horas > 24) || (minutos > 59)) {
																alert("Hora inválida!");
																elemento.val("");
															}
														}});
		<?php
			if(isset($_GET['mensagemalerta'])){
		?>
				jSuccess('<?php print $_GET['mensagemalerta']; ?>',
						{
					      autoHide : true, // added in v2.0
						  clickOverlay : true, // added in v2.0
					      TimeShown : 3000,
					      HorizontalPosition : 'center',
					      VerticalPosition : 'top',
					      MinWidth : 940
					    }
					);
		<?php
			} elseif(isset($_GET['mensagemerro'])) {
		?>
				jError('<?php print $_GET['mensagemerro']; ?>',
						{
					      autoHide : true, // added in v2.0
						  clickOverlay : true, // added in v2.0
					      TimeShown : 3000,
					      HorizontalPosition : 'center',
					      VerticalPosition : 'top',
					      MinWidth : 940
					    }
			);
		<?php
			}
		?>
	});
	tinymce.init({
		language : 'pt_BR',
		selector:'.mceAdvanced',
		width:'98%',
		plugins : 'advlist autolink link image lists charmap print preview code media ',
		theme: "modern", 
		plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor imagetools"
		],
		object_resizing : "img",
		toolbar1: "insertfile undo redo insert| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
		toolbar2: "print preview media | forecolor backcolor emoticons",
 	});
</script>

</head>
<body onload="startTime()">
	<input type="hidden" id="localizacao" value="<?=((isset($_SESSION['localizacao']))? "S" : "N")?>" />
	<div id="dialog-confirm"></div>
<!--[if lte IE 8]>
   <script>
      document.createElement('header');
      document.createElement('figure');
      document.createElement('hgroup');
      document.createElement('nav');
      document.createElement('section');
      document.createElement('article');
      document.createElement('aside');
      document.createElement('footer');
   </script>
<![endif]-->
	<div class="box_main">
		<?php include_once 'includes/menu.php' ?>
		<ul class="migalha">
			<li class="migalha_home"><a href="<?=ENDERECO?>" target='_blank'><img src="images/ico_house2.png" height="14" width="18" alt="ico" /></a></li>
			<li class="migalha_li"><a href=""><?php echo isset($_GET['mod']) ?  ucwords(str_replace("_"," ",$_GET['mod'])) : 'Home'?></a></li>
			<?php if(isset($_GET['acao'])){?>
				<li class="migalha_set"><img src="images/ico_migalha.png" height="8" width="7" alt="ico" /></li>
				<li class="migalha_txt">
					<?php
						if(isset($_GET['met']) and (strpos($_GET['met'],"cadas") !== FALSE or strpos($_GET['met'],"nova") !== FALSE) )
							echo "Cadastro";
						else if(isset($_GET['met']) and strpos($_GET['met'],"edit") !== FALSE)
							echo "Alterar cadastro";
						else if(isset($_GET['acao']) and strpos($_GET['acao'], "list") !==  FALSE)
							echo "Consulta";
						else if(isset($_GET['acao']) and strpos($_GET['acao'], "relatorioAcesso") !==  FALSE)
							echo "Relatório Acessos";
					?></li>
			<?php } ?>
		</ul>
		<section>
			<?php
			     include $mod."_mod.php";
			?>
	    </section>
    </div>
    <footer class="<?=(!isset($_SESSION['lateral']) || $_SESSION['lateral'] == "open" ? "" : 'footer_small' );?>">
    	<small>v3.0 - Copyright © <?php echo date('Y');?> Agência Red. Todos os direitos Reservado.</small>
    	<a class="ftop" href="">Topo</a>
    </footer>
</body>
</html>
<?php
	ob_end_flush();
?>
