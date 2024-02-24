<?php
	session_start();
	$chavex = isset($_SESSION["sgc_BUSLABJJD8392398192UJU1JAK"]) ? $_SESSION["sgc_BUSLABJJD8392398192UJU1JAK"] : '';
	
	if((empty($chavex)) || ($chavex != "BUSLABjd8u239y981u2i1jdioajs89d32AaKa")){
		header("location:login.php?msg=".urlencode('Acesso Negado!'));
		exit;
	}else{
		include_once 'usuario_class.php';		
		salvaUltimaAcao($_SESSION['sgc_idusuario']);
				
		$tmpQuery = explode('&', str_replace('mod=', '', $_SERVER['QUERY_STRING']));
		$MODULOACESSO['modulo'] = $tmpQuery[0];
		$MODULOACESSO['usuario'] = $_SESSION['sgc_idusuario'];
	}
?>