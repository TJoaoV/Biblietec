<?php
session_start();
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="PT">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../JS/alterarsenhaalunosjs.js"></script>
    <title> Alterar Senha </title>
</head>

<body>
    <h1> Alterar Senha </h1>
    <form action='finish/alterarsenhaalunos_finish.php' onsubmit="return validarprimeiro(this);" name='alterarsenha'
        method="post">
        <label> Senha atual: </label>
        <input type='password' name='txtsenhaatual' placeholder='Digite sua senha atual'><br>
        <label> Nova senha: </label>
        <input type='password' name='txtsenha1' placeholder='Digite sua nova senha'><br>
        <label> Confirme sua nova senha: </label>
        <input type='password' name='txtsenha2' placeholder='Digite novamente sua nova senha'><br>
        <input type="text" name="id" value="<?php echo $id ?>" hidden>
        <input id='btncontinuar' type='submit' name='btncontinuar' value='Continuar'>
    </form>
</body>

</html>