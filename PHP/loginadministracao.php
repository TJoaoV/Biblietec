<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
<<<<<<< HEAD
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/global.css">
        <link rel="stylesheet" href="../CSS/style.css">
        <title>Biblietec - Login</title>

        <!-- Importando fonte Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

        
=======
        <title>Biblietec - Login Administração</title>
        <?php include('imports.php'); ?>
>>>>>>> faa77822df1cf719da829a2c9521089173a4482e
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
