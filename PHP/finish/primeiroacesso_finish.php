<!DOCTYPE html>
<html>

<head>
    <?php include('importfinishs.php'); ?>
    <title> Biblietec - Gravando Aluno </title>

</head>

<body>
    <div class="login-box" style="height:30vh;">
        <h1 class='titulo'><span class="cor3">Bibli</span><span class="cor2">e</span>tec</h1>
        <?php
    include_once '../conexao.php';

    $rm = $_POST['txtrm'];
    $nome = $_POST['txtnome'];
    $cpf = $_POST["txtCPF"];
    $telefone = $_POST["txttelefone"];
    $celular = $_POST["txtcelular"];
    $email = $_POST["txtemail"];
    $dtnasc = $_POST["txtdtnascimento"];
    $senha = $_POST["txtsenha"];
    $curso = $_POST["txtcurso"];
    $senhac=md5($senha);
    $sql = "INSERT INTO alunos(alu_rm, alu_nome, alu_senh, alu_cpf, alu_tele, alu_celu, alu_emai, alu_dtna, cur_codi) 
                    VALUES ('" . $rm . "', '" . $nome . "', '" . $senhac . "', '" . $cpf . "', '" . $telefone . "', '" . $celular . "', '" . $email . "', '" . $dtnasc . "', '" . $curso . "')";
    $insere_cliente = mysqli_query($conn, $sql);

    if (mysqli_insert_id($conn)) {
        echo  "<h2> Aluno cadastrado com Sucesso! </h2>";
    } else {
        echo "<h2> Erro ao cadastrar o Aluno! </h2>";
        if ($conn -> error == "Duplicate entry '$rm' for key 'alu_rm'"){
            echo ("<h2>Usuário com RM: $rm já cadastrado!</h2>");
        }
        if ($conn -> error == "Duplicate entry '$cpf' for key 'alu_cpf'"){
            echo ("<h2>Usuário com CPF: $cpf já cadastrado!</h2>");
        }
        //else {
         //   echo ("Erro: "$conn -> error);
        //};
        
    }
     ?>
        <br>
        <div>
            <input id='btnlogin' type='button' value='Voltar' onClick="location.href = '../../index.php';">
        </div>
    </div>
    <br><br>
</body>

</html>