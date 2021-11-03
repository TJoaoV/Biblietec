<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Login Administração</title>
    <?php include('imports.php'); ?>
    <script type="text/javascript" src="../JS/loginadm.js"></script>
</head>

<body>
    <form onsubmit="return validaradm(this);" action='finish/loginadm_finish.php' method='POST' name='login' class=''>
        <div class="login-box">
            <a href='../index.php' class="textdecor">
                <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
            </a>
            <h2>Login - Administração</h2>
            <h3>Usuário:</h3>
            <input type='text' id='txtusuario' name='txtusuario' placeholder='Digite o usuário'><br>
            <h3>Senha:</h3>
            <input type='password' id='txtsenha' name='txtsenha' placeholder='Digite sua senha'><br><br>
            <input id='btnesquecisenha' type='button' name='btnesquecisenha' value='Esqueci a senha'
                onClick="location.href = 'PHP/teste2.php';">
            <input id='btnlogin' type='submit' name='btnlogin' value='Entrar'>
        </div>
    </form>
</body>

</html>