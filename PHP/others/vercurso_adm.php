<?php
    include_once("../conexao.php");
    $idCurso= $_POST['idCurso'];
    $produtossql1 = "SELECT * FROM cursos WHERE cur_codi='$idCurso'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    $exibir1 = mysqli_fetch_assoc($resultado_produtos1);
    $codi = $exibir1['cur_codi'];
    $nome = $exibir1['cur_nome'];
    $duracao = $exibir1['cur_dura'];
    $periodo = $exibir1['cur_peri'];
    echo json_encode(
        array("codigo" => $codi,
        "nome" => $nome,
        "duracao" => $duracao,
        "periodo" => $periodo)
    )
?>