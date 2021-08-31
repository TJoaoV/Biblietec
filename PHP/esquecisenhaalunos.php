<?php
include_once("conexao.php");
$sql = "SELECT * FROM alunos";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../JS/esquecisenhaalunosjs.js"></script>
    <title> Esqueci a senha </title>
</head>
<body>
    <form action="finish/esquecisenhaalunos_finish.php" onsubmit="return validarprimeiro(this);" name="esquecisenha" method="post">
        <h3>Nome:</h3>
        <input type='text' name='txtnome' id='txtnome' placeholder='Digite o nome'><br>
        <h3>CPF:</h3>
        <input type='text' name='txtCPF' id='txtCPF' placeholder='Digite o CPF SEM PONTUAÇÃO'><br>
        <h3>RM:</h3>
        <input type='text' name='txtRM' id='txtRM' placeholder='Digite o RM'><br>
        <input id='btncontinuar' type='submit' name='btncontinuar' value='Continuar'>
    </form>
</body>
</html>