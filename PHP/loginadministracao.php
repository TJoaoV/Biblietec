<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Biblietec - Login</title>
        <?php include('imports.php'); ?>
    </head>
    <body>
        <form action='PHP/valida.php' method='POST' name='login' class=''> 
            <div class="login-box">
                <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
                <h2>Login - Administração</h2>
                <h3>Usuário:</h3>
                <input type='text' name='txtusuario' placeholder='Digite o usuário'><br>
                <h3>Senha:</h3>
                <input type='password' name='txtsenha' placeholder='Digite sua senha'><br><br>    
                <input id='btnesquecisenha' type='button' name='btnesquecisenha' value='Esqueci a senha' onClick="location.href = 'PHP/teste2.php';">
                <input id='btnlogin' type='submit' name='btnlogin' value='Entrar'>
            </div>
        </form>
    </body>
</html>
