<?php
    include_once("conexao.php");
    $tabela= $_POST['tabela'];
    $produtossql1 = "SELECT * FROM $tabela";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    $quantidade_rows =  $resultado_produtos1->num_rows;
    echo $quantidade_rows; 
?>