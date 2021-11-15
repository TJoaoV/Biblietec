<?php
    include_once("../conexao.php");
    $codigoUsu= $_POST['codigoUsu'];
    $nomeUsu= $_POST['nomeUsu'];
    $loginUsu= $_POST['loginUsu'];
    $endeUsu= $_POST['endeUsu'];
    $teleUsu= $_POST['teleUsu'];
    $celuUsu= $_POST['celuUsu'];
    $emailUsu= $_POST['emailUsu'];
    $permiOLDUsu= $_POST['permiOLDUsu'];
    $permiNEWUsu= $_POST['permiNEWUsu'];
    $situacaoOLDUsu= $_POST['situacaoOLDUsu'];
    $situacaoNEWUsu= $_POST['situacaoNEWUsu'];
    if($situacaoOLDUsu == "Usuário Inativo"){
        $situacao = "0";
    }
    if($situacaoOLDUsu == "Usuário Ativo"){
        $situacao = "1";
    }
    $permissao = $permiOLDUsu;
    if ($permiNEWUsu != "-"){
        $permissao = $permiNEWUsu;
    };
    if ($situacaoNEWUsu != "-"){
        $situacao = $situacaoNEWUsu;
    };
    $produtossql4 = "UPDATE usuario SET usu_nome='$nomeUsu', usu_logi='$loginUsu', usu_ende='$endeUsu', usu_tele='$teleUsu', usu_celu='$celuUsu', usu_emai='$emailUsu', usu_perm='$permissao', usu_ativ='$situacao' WHERE usu_codi = '$codigoUsu'";
    $resultado_produtos4 = mysqli_query($conn, $produtossql4);
    echo "Alteração concluida!";
?>