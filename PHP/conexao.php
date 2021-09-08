<?php
    header('Content-Type: text/html; charset=utf-8');
	$servidor = "localhost";
	$usuario = "biblietec";
	$senha = "";
	$dbname = "biblietec";
	
	//Criar a conexao
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
	mysqli_set_charset($conn,"utf8");
?>