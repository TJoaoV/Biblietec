<?php
    include_once("../conexao.php");
    $idUsuario= $_POST['idUsuario'];
    $produtossql1 = "SELECT * FROM usuario WHERE usu_codi='$idUsuario'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    $exibir1 = mysqli_fetch_assoc($resultado_produtos1);
    $nome = $exibir1['usu_nome'];
    $login = $exibir1['usu_logi'];
    $cpf = $exibir1['usu_cpf'];
    $endereco = $exibir1['usu_ende'];
    $datanasc = $exibir1['usu_dtna'];
    $telefone = $exibir1['usu_tele'];
    $celular = $exibir1['usu_celu'];
    $email = $exibir1['usu_emai'];
    $permissao = $exibir1['usu_perm'];
    $senha = $exibir1['usu_reds'];
    $ativo = $exibir1['usu_ativ'];
    if ($ativo == "1"){
        $status = "Usuário Ativo";
    }
    if ($ativo == "0"){
        $status = "Usuário Inativo";
    }
    if ($senha == "1"){
        $statusenha = "Redefinição Pendente";
    }
    if ($senha == "0"){
        $statusenha = "Normal";
    }
    echo json_encode(
        array("codigo" => $idUsuario,
        "nome" => $nome,
        "login" => $login,
        "cpf" => $cpf,
        "endereco" => $endereco,
        "dtna" => $datanasc,
        "telefone" => $telefone,
        "celular" => $celular,
        "email" => $email,
        "permissao" => $permissao,
        "senha" => $statusenha,
        "situacao" => $status)
    )
?>