<!DOCTYPE html>
<html lang="PT">

<head>
    <?php include('importfinishs.php'); ?>
    <title>Biblietec - Alterar Senha</title>
</head>

<body>
    <div class="login-box" style="height: 20vh">
        <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
        <?php
            session_start();
            include_once("../conexao.php");
            $senhaantiga = filter_input(INPUT_POST, 'txtsenhaatualADM', FILTER_SANITIZE_STRING);
            $senha1 = filter_input(INPUT_POST, 'txtsenha1ADM', FILTER_SANITIZE_STRING);
            $senha2 = filter_input(INPUT_POST, 'txtsenha2ADM', FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $result_usuario = "SELECT * FROM usuario WHERE usu_codi='$id' LIMIT 1";
            $resultado_usuario = mysqli_query($conn, $result_usuario);
            if($resultado_usuario == TRUE){
                $row_usuario = mysqli_fetch_assoc($resultado_usuario);
                $_SESSION['senha'] = $row_usuario['usu_senh'];
                $senhac=md5($senhaantiga);
                if ($_SESSION['senha'] == $senhac){
                    $senhanova = md5($senha1);
                    $sql = "UPDATE usuario SET usu_senh='$senhanova', usu_reds='0' WHERE usu_codi = '$id'";
                    $resultadoupdate = mysqli_query($conn, $sql);
                    echo "<div class='alinharmeio' style='font-size: 1.4rem;'><b>Senha alterada com sucesso!</b></div>";
                    
                } else {
<<<<<<< HEAD
                    echo "<div class='alinharmeio' style='font-size: 1.4rem;'><b>Senha antiga incorreta!</b></div>";
=======
                    echo "<h3>Senha antiga incorreta!</h3>";
>>>>>>> 7c8373ea620e02974013bad3cea42f30d2157184
                }
                
            }
            ?>
        <input id='btnlogin' type='button' name='btnvoltar' value='Voltar' onClick="location.href = '../loginadministracao.php';">
    </div>
</body>

</html>