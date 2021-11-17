<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $rmaluno= $_POST['rmaluno'];
    $now = date('Y-m-d');
    $resultado = "0";
    $produtossql3 = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$rmaluno' and emp_devo='NÃO Devolvido'";
    $resultado_produtos3 = mysqli_query($conn, $produtossql3);
    while ($exibir3 = mysqli_fetch_assoc($resultado_produtos3)) {
        $datadevolucao = $exibir3['emp_dtde'];
        if(strtotime($now) > strtotime($datadevolucao)){
            $resultado = "1";
        }
    }
    echo $resultado;
?>