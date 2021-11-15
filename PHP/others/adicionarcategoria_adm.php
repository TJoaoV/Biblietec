<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $categoriaADD= $_POST['categoriaADD'];
    $produtossql1 = "INSERT INTO categoria (cat_nome) 
                    VALUES ('".$categoriaADD."');";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    echo "Categoria ".$categoriaADD. " adicionada com sucesso!";
?>