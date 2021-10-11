<?php
    include_once("../conexao.php");
    $idaluno= $_POST['idaluno'];
    $produtossql1 = "SELECT * FROM alunos WHERE alu_codi='$idaluno'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    $exibir1 = mysqli_fetch_assoc($resultado_produtos1);
    $codi = $exibir1['alu_codi'];
    $rm = $exibir1['alu_rm'];
    $nome = $exibir1['alu_nome'];
    $cpf = $exibir1['alu_cpf'];
    $telefone = $exibir1['alu_tele'];
    $celular = $exibir1['alu_celu'];
    $email = $exibir1['alu_emai'];
    $datanascimento = $exibir1['alu_dtna'];
    $curso = $exibir1['cur_codi'];
    $senha = $exibir1['alu_reds'];
    $buscacategoria = "SELECT * FROM cursos WHERE cur_codi='$curso'";
    $resultado_categoria = mysqli_query($conn, $buscacategoria);
    $exibir2 = mysqli_fetch_assoc($resultado_categoria);
    $categoria = $exibir2['cur_nome'];
    echo json_encode(
        array("codigo" => $codi,
        "rm" => $rm,
        "nome" => $nome,
        "cpf" => $cpf,
        "telefone" => $telefone,
        "celular" => $celular,
        "email" => $email,
        "datanascimento" => $datanascimento,
        "cursoid" => $curso,
        "cursonome" => $categoria,
        "senharedefinida" => $senha)
    )
?>