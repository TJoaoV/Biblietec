<?php
    include_once("../conexao.php");
    $idemprestimo= $_POST['idemprestimo'];
    $idlivro= $_POST['idlivro'];
    $produtossql1 = "DELETE FROM corpo_emprestimo where cor_codi='$idemprestimo'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);

    $produtossql3 = "SELECT * FROM livros WHERE liv_codi='$idlivro'";
    $resultado_produtos3 = mysqli_query($conn, $produtossql3);
    $exibir3 = mysqli_fetch_assoc($resultado_produtos3);
    $quantidadedisponivel = $exibir3['liv_qtdd'];
    $nomelivro = $exibir3['liv_titu'];

    $novaquantidadelivros = $quantidadedisponivel + 1;
    $produtossql4 = "UPDATE livros SET liv_qtdd = '$novaquantidadelivros' WHERE liv_codi = '$idlivro'";
    $resultado_produtos4 = mysqli_query($conn, $produtossql4);


    echo "Empréstimo do livro ".$nomelivro." removido!";
?>