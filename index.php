<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Biblietec - Login</title>
    <?php include('importindex.php'); ?>
    <script type="text/javascript" src="JS/indexjs.js"></script>
</head>

<body>
    <div class="login-box" style="height:55vh;">
        <a href='index.php' class="textdecor">
            <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
        </a>
        <h2>Login - Alunos</h2>
        <form method='POST' name='login' onsubmit="return validar(this);" action='PHP/loginalunos.php'>
            <h3>CPF:</h3>
            <input type='text' name='txtCPF' id='txtCPF' placeholder='Digite o CPF (Sem pontuação)'><br>
            <h3>Senha:</h3>
            <input type='password' name='txtsenha' id='txtsenha' placeholder='Digite sua senha'><br><br>
            <input class="botLoginbox" id='btncadastro' type='button' name='btncadastro'
                value='Primeiro Acesso? Clique aqui!' onClick="location.href = 'PHP/primeiroacesso.php';">
            <input class="botLoginbox" id='btnesquecisenha' type='button' name='btnesquecisenha' value='Esqueci a senha'
                onClick="location.href = 'PHP/esquecisenhaalunos.php';">
            <input class="botLoginbox" id='btnadministracao' type='button' name='btnadministracao'
                value='Administração? Clique aqui' onClick="location.href = 'PHP/loginadministracao.php';">
            <input class="botLoginbox" id='btnlogin' type='submit' name='btnlogin' value='Entrar'>
    </div>
    </form>
</body>

</html>