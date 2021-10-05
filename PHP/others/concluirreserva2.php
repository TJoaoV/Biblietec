<?php
    include_once("../conexao.php");
    $rmaluno= $_POST['rmaluno'];
    $idlivro= $_POST['idlivro'];
    $tabelaempcodi= $_POST['tabelaempcodi'];
    $devolucao= $_POST['devolucao'];
    $now= $_POST['now'];
    $produtossql1 = "INSERT INTO corpo_emprestimo(emp_codi, liv_codi, emp_dtde, emp_devo, alu_rm) 
                    VALUES ('$tabelaempcodi','$idlivro', '$devolucao', 'NÃO Devolvido', '$rmaluno');";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);

    $produtossql3 = "DELETE FROM preemprestimo where liv_codi='$idlivro' and alu_rm='$rmaluno'";
    $resultado_produtos3 = mysqli_query($conn, $produtossql3);

    $produtossql2 = "SELECT * FROM livros WHERE liv_codi='$idlivro'";
    $resultado_produtos2 = mysqli_query($conn, $produtossql2);
    $exibir2 = mysqli_fetch_assoc($resultado_produtos2);
    $nomelivro = $exibir2['liv_titu'];

    echo "Livro ".$nomelivro." adicionado a reserva!";
?>