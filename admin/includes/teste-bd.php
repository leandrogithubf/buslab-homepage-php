<?php

$host = "localhost";
$port = "3306";
$user = "agencia_red";
$password = "%2fMnS5*nop2oAXm&D5T!kF!6f6ro5";
$database = "buslab_site";

$conexao = mysqli_connect($host, $user, $password, $database, $port) or exit(mysqli_connect_error());

if ($conexao) {
    echo 'A conexão está funcionando' . "\n";
} elseif ($conexao) {
    echo 'A conexão não está funcionando' . "\n";
}

echo '<pre>';
$query = mysqli_query($conexao, 'SELECT * FROM banner;');
while ($row = mysqli_fetch_assoc($query)){
   	var_dump($row);
}
echo '</pre>';
