<!DOCTYPE html>
<html>

<head>
    <title> Gravando Aluno </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
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
        $produtossql1 = "SELECT * FROM alunos";
        $resultado_produtos1 = mysqli_query($conn, $produtossql1);
        $quantidade_rows =  $resultado_produtos1->num_rows;
        $linhas = $quantidade_rows - 1;
        $alterarauto = "ALTER TABLE alunos AUTO_INCREMENT ='$linhas'";
        $funcao = mysqli_query($conn, $alterarauto);
        echo "<h2> Erro ao cadastrar o Aluno! </h2>";
        if ($conn -> error == "Duplicate entry '$rm' for key 'alu_rm'"){
            echo ("Usuário com RM: $rm já cadastrado!");
        }
        if ($conn -> error == "Duplicate entry '$cpf' for key 'alu_cpf'"){
            echo ("Usuário com CPF: $cpf já cadastrado!");
        }
        //else {
         //   echo ("Erro: "$conn -> error);
        //};
        
    }
    ?>
    <br><br>
    <div>
        <a href="../../index.php">Voltar</a>
    </div>
    <br><br>
</body>

</html>