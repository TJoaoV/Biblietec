<?php
    include_once("../conexao.php");
    date_default_timezone_set('America/Sao_Paulo'); 
    $datadehoje = date('Y-m-d');
    $codigoemprestimo= $_POST['codigoemprestimo'];
    $usuariocodigo= $_POST['usuariocodigo'];
    $senha= $_POST['senha'];
    $sql = "SELECT * FROM usuario WHERE usu_codi='$usuariocodigo'";
    $resultado = mysqli_query($conn, $sql);
    $resultadosenha = mysqli_fetch_assoc($resultado);
    $senhacrip = md5($senha);
    if($resultadosenha['usu_senh'] == $senhacrip){
        $produtossql4 = "UPDATE corpo_emprestimo SET emp_devo = 'Devolvido', cor_dtde = '$datadehoje' WHERE cor_codi = '$codigoemprestimo'";
        $resultado_produtos4 = mysqli_query($conn, $produtossql4);
        $sql2 = "SELECT * FROM corpo_emprestimo WHERE cor_codi = '$codigoemprestimo'";
        $resultado2 = mysqli_query($conn, $sql2);
        $resultadosenha2 = mysqli_fetch_assoc($resultado2);
        $idlivro = $resultadosenha2['liv_codi'];
        $sql3 = "SELECT * FROM livros WHERE liv_codi = $idlivro";
        $resultado3 = mysqli_query($conn, $sql3);
        $resultadosenha3 = mysqli_fetch_assoc($resultado3);
        $quantidadedisponivel = $resultadosenha3['liv_qtdd'] + 1;
        $produtossql = "UPDATE livros SET liv_qtdd = '$quantidadedisponivel' WHERE liv_codi = '$idlivro'";
        $resultado_produtos = mysqli_query($conn, $produtossql);
        echo "Livro Devolvido com sucesso!";
    } else {
        echo "Senha Incorreta!";
    };
?>