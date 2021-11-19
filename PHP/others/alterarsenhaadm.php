<?php
session_start();
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="PT">

<head>
    <?php include('importsothers.php'); ?>
    <script type="text/javascript" src="../JS/alterarsenhaadm.js"></script>
    <title> Biblietec- Alterar Senha </title>
</head>

<body>
    <div class="login-box">
    <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
        <h2> Alterar Senha </h2>
        <form action='../finish/alterarsenhaadm_finish.php' onsubmit="return validarprimeiro(this);"
            name='alterarsenhaadm' method="post">
            <h3> Senha atual: </h3>
            <input type='password' name='txtsenhaatualADM' placeholder='Digite sua senha atual'><br>
            <h3> Nova senha: </h3>
            <input type='password' name='txtsenha1ADM' placeholder='Digite sua nova senha'><br>
            <h3> Confirme sua nova senha: </h3>
            <input type='password' name='txtsenha1ADM' placeholder='Digite novamente sua nova senha'><br>
            <input type="text" name="id" value="<?php echo $id ?>" hidden>
            <br>
            <input id='btnlogin' type='submit' name='btncontinuar' value='Continuar'>
        </form>
    </div>
</body>

</html>