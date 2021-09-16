<?php 
session_start();
$mensagem = $_SESSION['msg'];
echo $mensagem;
echo "<a href='../../index.php'> voltar </a>"

?>