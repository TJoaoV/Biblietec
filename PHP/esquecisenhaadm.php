<?php
include_once("conexao.php");
$sql = "SELECT * FROM alunos";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="PT">

<head>
    <title> Biblietec - Esqueci a senha </title>
    <?php include('imports.php'); ?>
    <script type="text/javascript" src="../JS/esquecisenhaadm.js"></script>
</head>

<body>
    <div style="height: 40vh !important;" class="login-box esquecitela">
        <a href='../index.php' class='textdecor'>
            <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
        </a>
        <h2>Redefinir Senha</h2>
        <form action="finish/esquecisenhaadm_finish.php" onsubmit="return validarprimeiro(this);" name="esquecisenhaadm"
            method="post">
            <h3>CPF:</h3>
            <input type='text' onkeypress="return event.charCode >= 48 && event.charCode <= 57" name='txtCPF' id='txtCPF' maxlength="11" placeholder='Digite o CPF (Sem pontuação)'><br>
            <h3>Login:</h3>
            <input type='text' name='txtLogin' id='txtLogin' maxlength="50" placeholder='Digite o Login'><br><br>
            <input id='btnlogin' type='submit' name='btncontinuar' value='Continuar'>
        </form>
    </div>
</body>

</html>