<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $datadehoje = date('Y-m-d');
    $rmaluno= $_POST['rmaluno'];
    $idlivro= $_POST['idlivro'];
    $devolucao= $_POST['devolucao'];
    $now= $_POST['now'];
    // $tabelaempcodigo = $_POST['tabelaempcodigo'];
    $resultado = "0";
    $produtossql3 = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$rmaluno' and emp_devo='NÃO Devolvido'";
    $resultado_produtos3 = mysqli_query($conn, $produtossql3);
    while ($exibir3 = mysqli_fetch_assoc($resultado_produtos3)) {
        $datadevolucao = $exibir3['emp_dtde'];
        if(strtotime($now) < strtotime($datadevolucao)){
            $resultado = "1";
        } else {
            $resultado = "0";
        }
    }
    if ($resultado == "1"){
        echo "Você deve devolver o livro pendente antes de reservar outro!";
    } else {
        $codigo = "SELECT * FROM emprestimo WHERE alu_rm='$rmaluno' and emp_data='$datadehoje'";
        $cod = mysqli_query($conn, $codigo);
        $exibircod = mysqli_fetch_assoc($cod);
        $idemprestimo = $exibircod['emp_codi'];
    
        $produtossql1 = "INSERT INTO corpo_emprestimo(emp_codi, liv_codi, emp_dtde, emp_devo, alu_rm) 
                        VALUES ('$idemprestimo','$idlivro', '$devolucao', 'NÃO Devolvido', '$rmaluno');";
        $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    
        $produtossql3 = "DELETE FROM preemprestimo where liv_codi='$idlivro' and alu_rm='$rmaluno'";
        $resultado_produtos3 = mysqli_query($conn, $produtossql3);
    
        $produtossql2 = "SELECT * FROM livros WHERE liv_codi='$idlivro'";
        $resultado_produtos2 = mysqli_query($conn, $produtossql2);
        $exibir2 = mysqli_fetch_assoc($resultado_produtos2);
        $nomelivro = $exibir2['liv_titu'];
    
        echo "Livro ".$nomelivro." adicionado a reserva!";
    };

    
?>