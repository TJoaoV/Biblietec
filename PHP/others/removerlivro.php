<?php
    include_once("../conexao.php");
    $idtable= $_POST['idtable'];
    $produtossql1 = "DELETE FROM preemprestimo where pre_codi='$idtable'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    echo "Produto Removido!";
?>