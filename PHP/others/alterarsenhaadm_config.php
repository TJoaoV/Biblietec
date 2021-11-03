<?php
    include_once("../conexao.php");
    $usuarioadm= $_POST['usuarioadm'];
    $senhaantiga= $_POST['senhaantiga'];
    $senhanova1= $_POST['senhanova1'];
    $senhanova2= $_POST['senhanova2'];
    $senhaantigac = md5($senhaantiga);
    $produtossql1 = "SELECT * FROM usuario WHERE usu_codi='$usuarioadm'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    if($exibir1 = mysqli_fetch_assoc($resultado_produtos1)){
        if($senhaantigac == $exibir1['usu_senh']){
            if($senhanova1 == $senhanova2){
                $novasenhac = md5($senhanova1);
                $produtossql2 = "UPDATE usuario SET usu_senh='$novasenhac' WHERE usu_codi='$usuarioadm'";
                $resultado_produtos2 = mysqli_query($conn, $produtossql2);
                echo "Senha alterada com Sucesso!";
            }else {
                echo "As senhas não conferem!";
            }
        } else {
            echo "Senha antiga incorreta!";
        }
    }else {
        echo "Erro de conexão com banco de dados!";
    }
    
    
?>