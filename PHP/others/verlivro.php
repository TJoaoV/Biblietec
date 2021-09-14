<?php
    include_once("../conexao.php");
    $idlivro= $_POST['idlivro'];
    $produtossql1 = "SELECT * FROM livros WHERE liv_codi='$idlivro'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    $exibir1 = mysqli_fetch_assoc($resultado_produtos1);
    $nome = $exibir1['liv_titu'];
    $autor = $exibir1['liv_auto'];
    $editora = $exibir1['liv_edit'];
    $sinopse = $exibir1['liv_sino'];
    $categoriaid = $exibir1['cat_codi'];
    $buscacategoria = "SELECT * FROM categoria WHERE cat_codi='$categoriaid'";
    $resultado_categoria = mysqli_query($conn, $buscacategoria);
    $exibir2 = mysqli_fetch_assoc($resultado_categoria);
    $categoria = $exibir2['cat_nome'];
    echo json_encode(
        array("codigo" => $idlivro,
        "nome" => $nome,
        "autor" => $autor,
        "editora" => $editora,
        "sinopse" => $sinopse,
        "categoria" => $categoria)
    )
?>