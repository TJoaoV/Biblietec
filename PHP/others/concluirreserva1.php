<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $rmaluno= $_POST['rmaluno'];
    $now= $_POST['now'];
    $resultado = "0";
    $produtossql3 = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$rmaluno' and emp_devo='NÃO Devolvido'";
    $resultado_produtos3 = mysqli_query($conn, $produtossql3);
        $produtossql1 = "INSERT INTO emprestimo(alu_rm, emp_data) 
                        VALUES ('$rmaluno','$now');";
        $resultado_produtos1 = mysqli_query($conn, $produtossql1);
        $produtossql2 = "SELECT * FROM emprestimo WHERE alu_rm='$rmaluno' ORDER BY emp_codi DESC LIMIT 1";
        $resultado_produtos2 = mysqli_query($conn, $produtossql2);
        $exibir2 = mysqli_fetch_assoc($resultado_produtos2);
        $codigo = $exibir2['emp_codi'];
        echo $codigo;
?>