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
    <script type="text/javascript" src="../JS/esquecisenhaalunosjs.js"></script>
</head>

<body>
    <div class="login-box esquecitela">
        <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
        <h2>Redefinir Senha</h2>
        <form action="finish/esquecisenhaalunos_finish.php" onsubmit="return validarprimeiro(this);" name="esquecisenha"
            method="post">
            <h3>Nome:</h3>
            <input type='text' name='txtnome' id='txtnome' placeholder='Digite o nome'><br>
            <h3>CPF:</h3>
            <input type='text' name='txtCPF' id='txtCPF' placeholder='Digite o CPF (Sem pontuação)'><br>
            <h3>RM:</h3>
            <input type='text' name='txtRM' id='txtRM' placeholder='Digite o RM'><br><br>
            <input id='btnlogin' type='submit' name='btncontinuar' value='Continuar'>
        </form>
    </div>
</body>

</html>