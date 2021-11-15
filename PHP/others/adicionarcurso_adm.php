<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $nomeADD= $_POST['nomeADD'];
    $duracaoADD= $_POST['duracaoADD'];
    $periodoADD= $_POST['periodoADD'];
    $produtossql1 = "INSERT INTO cursos (cur_nome, cur_dura, cur_peri) 
                    VALUES ('".$nomeADD."','".$duracaoADD."','".$periodoADD."');";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    echo "Curso ".$nomeADD. " adicionado com sucesso!";
?>