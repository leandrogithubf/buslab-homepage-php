<?php @ob_start();
    @session_start();

    $postArray = isset($_REQUEST['p']) ? explode("/",$_REQUEST['p']) : array();
    $testa =  getcwd();

	if($testa == "/home/admin/web/in.agencia.red/public_html/buslab"){
        @define('ENDERECO', 'http://'.$_SERVER['HTTP_HOST'].'/buslab/');
    }elseif($testa == "C:\\xampp\htdocs\buslab.com.br"){
        @define('ENDERECO', 'http://'.$_SERVER['HTTP_HOST'].'/buslab.com.br/');
    }
    elseif($testa == "/home3/web/public_html/buslab"){
        @define('ENDERECO', 'https://'.$_SERVER['HTTP_HOST'].'/buslab/');
    }
    else{
        @define('ENDERECO', 'https://'.$_SERVER['HTTP_HOST'].'/');
    }

	$_SESSION['modulo'] = isset($postArray[0]) ? $postArray[0] : '';
	$_SESSION['idu'] = isset($postArray[1]) ? $postArray[1] : '';
	$_SESSION['extra'] = isset($postArray[2]) ? $postArray[2] : '';
	$_SESSION['extra2'] = isset($postArray[3]) ? $postArray[3] : '';
	$_SESSION['extra3'] = isset($postArray[4]) ? $postArray[4] : '';
	$_SESSION['extra4'] = isset($postArray[5]) ? $postArray[5] : '';

   include_once("idiomas.php");

	$MODULO = $_SESSION['idu'];

   define('ENDERECO_IDIOMA', ENDERECO. $_SESSION['IDIOMA_URL'] . "/"); 

   if (!empty($postArray) && substr($_REQUEST['p'], -1) == "/") { 
      $url = substr($_REQUEST['p'], 0, -1);
      // header("HTTP/1.1 301 Moved Permanently");
      header("Location:" . ENDERECO . $url);
   } 

	switch($_SESSION['modulo']){
		default :
			$PAGINA = 'index';
		break;
	}

	include_once("verifica_link.php");
?>
