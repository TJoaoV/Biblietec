<?php
    include_once("../conexao.php");
    $idtable= $_POST['idtable'];
    $idlivro=$_POST['idlivro'];
    $produtossql1 = "DELETE FROM preemprestimo where pre_codi='$idtable'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);

    $produtossql3 = "SELECT * FROM livros WHERE liv_codi='$idlivro'";
    $resultado_produtos3 = mysqli_query($conn, $produtossql3);
    $exibir3 = mysqli_fetch_assoc($resultado_produtos3);
    $quantidadedisponivel = $exibir3['liv_qtdd'];

    $novaquantidadelivros = $quantidadedisponivel + 1;
    $produtossql4 = "UPDATE livros SET liv_qtdd = '$novaquantidadelivros' WHERE liv_codi = '$idlivro'";
    $resultado_produtos4 = mysqli_query($conn, $produtossql4);


    echo "Produto Removido!";
?>