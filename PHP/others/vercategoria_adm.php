<?php
    include_once("../conexao.php");
    $idCategoria= $_POST['idCategoria'];
    $produtossql1 = "SELECT * FROM categoria WHERE cat_codi='$idCategoria'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    $exibir1 = mysqli_fetch_assoc($resultado_produtos1);
    $codi = $exibir1['cat_codi'];
    $nome = $exibir1['cat_nome'];
    echo json_encode(
        array("codigo" => $codi,
        "nome" => $nome)
    )
?>