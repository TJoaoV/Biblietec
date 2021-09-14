<?php
include_once("conexao.php");
$sql = "SELECT * FROM cursos";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Cadastro</title>
    <?php include('imports.php'); ?>
    <script type="text/javascript" src="../JS/primeiroacessoj.js"></script>
</head>

<body>
    <div class='corpoCadastro'>
        <form action="finish/primeiroacesso_finish.php" onsubmit="return validarprimeiro(this);" method='POST'
            name='cadastro' class=''>
            <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
            <h2>Cadastro</h2>

            <h3>RM:</h3>
            <input type='text' name='txtrm' maxlength="11" placeholder='Digite o RM'><br>

            <h3>Nome Completo: </h3>
            <input type='text' name='txtnome' maxlength="100" placeholder='Digite o nome completo'><br>

            <h3>CPF:</h3>
            <input type='text' id='txtCPF' name='txtCPF' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="15" placeholder='Digite o CPF (Sem pontuação)'><br>

            <h3>Telefone:</h3>
            <input type='text' onkeypress="return event.charCode >= 48 && event.charCode <= 57" name='txttelefone' maxlength="10" placeholder='Digite o Telefone'><br>

            <h3>Celular:</h3>
            <input type='text' onkeypress="return event.charCode >= 48 && event.charCode <= 57" name='txtcelular' maxlength="11" placeholder='Digite o Celular'><br>

            <h3>Email:</h3>
            <input type='email' name='txtemail' maxlength="150" placeholder='Digite o Email'><br>

            <h3>Data de Nascimento:</h3>
            <input type='date' name='txtdtnascimento' placeholder='Digite a Data de Nascimento'><br>

            <h3>Senha:</h3>
            <input type='password' name='txtsenha' placeholder='Digite sua senha'><br>

            <h3>Repita a Senha:</h3>
            <input type='password' name='txtsenha2' placeholder='Digite sua senha novamente'><br>

            <h3>Curso:</h3>
            <?php
            echo "<select name='txtcurso'>";
            echo "<option value='-'> Selecione o Curso </option>";
            while ($exibir = mysqli_fetch_assoc($resultado)) {
                echo "<option value='$exibir[cur_codi]'> $exibir[cur_nome]</option>";
            } 
            echo "</select>";
            ?>
            <br>
            <br>
            <div class="alinharmeio">
                <input id='btnlogin' type='submit' name='btnlogin' value='Cadastrar'>
            </div>
        </form>
    </div>
</body>

</html>