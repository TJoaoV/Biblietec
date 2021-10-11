<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $datadehoje = date('Y-m-d');
    $codigoemprestimo= $_POST['codigoemprestimo'];
    $usuariocodigo= $_POST['usuariocodigo'];
    $senha= $_POST['senha'];
    $sql = "SELECT * FROM usuario WHERE usu_codi='$usuariocodigo'";
    $resultado = mysqli_query($conn, $sql);
    $resultadosenha = mysqli_fetch_assoc($resultado);
    $senhacrip = md5($senha);
    if($resultadosenha['usu_senh'] == $senhacrip){
        $produtossql4 = "UPDATE corpo_emprestimo SET cor_pego = 1, cor_dten = '$datadehoje', usu_codi = '$usuariocodigo' WHERE cor_codi = '$codigoemprestimo'";
        $resultado_produtos4 = mysqli_query($conn, $produtossql4);
        echo "Livro entregue com sucesso!";
    } else {
        echo "Senha Incorreta!";
    };
?>