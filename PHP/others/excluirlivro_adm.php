<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $idlivro= $_POST['idlivro'];
    $produtossql1 = "DELETE FROM livros where liv_codi='$idlivro'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    echo "Livro Excluido!";
?>