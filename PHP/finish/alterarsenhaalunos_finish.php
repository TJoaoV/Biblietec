<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
</head>
<body>
<?php
session_start();
include_once("../conexao.php");
$senhaantiga = filter_input(INPUT_POST, 'txtsenhaatual', FILTER_SANITIZE_STRING);
$senha1 = filter_input(INPUT_POST, 'txtsenha1', FILTER_SANITIZE_STRING);
$senha2 = filter_input(INPUT_POST, 'txtsenha2', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
$result_usuario = "SELECT * FROM alunos WHERE alu_codi='$id' LIMIT 1";
$resultado_usuario = mysqli_query($conn, $result_usuario);
if($resultado_usuario == TRUE){
    $row_usuario = mysqli_fetch_assoc($resultado_usuario);
    $_SESSION['senha'] = $row_usuario['alu_senh'];
    $senhac=md5('1234');
    if ($_SESSION['senha'] == $senhac){
        $senhanova = md5($senha1);
        $sql = "UPDATE alunos SET alu_senh='$senhanova', alu_reds='0' WHERE alu_codi = '$id'";
        $resultadoupdate = mysqli_query($conn, $sql);
        echo "Senha alterada com sucesso!!";
        
    }
    
}
?>
<input id='btnvoltar' type='button' name='btnvoltar' value='Voltar' onClick="location.href = '../../index.php';">
</body>
</html>
