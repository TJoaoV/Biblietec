<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('importfinishs.php'); ?>
    <title>Biblietec - Alterar Senha</title>
</head>

<body>
    <div class="login-box" style="height: 20vh">
        <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
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
    $antigasenha=md5($senhaantiga);
    if($antigasenha == $_SESSION['senha']){
        $senhac=md5('1234');
        if ($_SESSION['senha'] == $senhac){
            $senhanova = md5($senha1);
            $sql = "UPDATE alunos SET alu_senh='$senhanova', alu_reds='0' WHERE alu_codi = '$id'";
            $resultadoupdate = mysqli_query($conn, $sql);
            echo "<div class='alinharmeio'><h3>Senha alterada com sucesso!</h3></div>";
            
        }
    } else {
        echo "<div class='alinharmeio'><h3>Senha antiga incorreta!</h3></div>";
    }
    
    
}
?>
        <input id='btnlogin' type='button' name='btnvoltar' value='Voltar' onClick="location.href = '../../index.php';">
    </div>
</body>

</html>