<?php 
session_start();
$mensagem = $_SESSION['msg'];
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Procura</title>
    <?php include('importserror.php'); ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="login-box" style="height: 22vh">
        <h2><?php echo $mensagem ?></h2>
        <button class="botVerm pointer" style="width: 15vw;" onclick="location.href='../loginadministracao.php'">Voltar</button>
    </div>
</body>