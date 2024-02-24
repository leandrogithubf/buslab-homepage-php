<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	//$host = $_SERVER['DB_HOST'];
	//$port = $_SERVER['DB_PORT'];
	//$user = $_SERVER['DB_USER'];
	//$password = $_SERVER['DB_PASS'];
	//$database = $_SERVER['DB_NAME'];

	$host = "bl-prd-mysql01.mysql.database.azure.com";
   	$port = "3306";
   	$user = "buslab";
   	$password = "5wBUg6ICxK";
   	$database = "buslab_site";

	$ENDERECO = 'https://'.$_SERVER['HTTP_HOST'].'/admin/';

	$conexao = mysqli_connect($host, $user, $password, $database, $port) or exit(mysqli_connect_error());

	mysqli_select_db($conexao, $database) || exit(mysqli_error($conexao));

	defined('ENDERECO') || define('ENDERECO', $ENDERECO);
