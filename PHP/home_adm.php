<?php
    $datadehoje = date('Y-m-d');
    session_start();
    try{
        $idRecebido = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    } catch (Exception $e){
    };
    $nome = $_SESSION['nome'];
    $login = $_SESSION['usuario'];
    require("conexao.php");
    $sql = "SELECT * FROM corpo_emprestimo WHERE emp_devo='NÃO Devolvido' and cor_pego=0";
    $resultado = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM corpo_emprestimo WHERE emp_devo='NÃO Devolvido' and cor_pego=1";
    $resultado2 = mysqli_query($conn, $sql2);
    // $sql_pre = "SELECT * FROM preemprestimo WHERE alu_rm='$rm'";
    // $sql_emprestimoprogresso = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$rm' and emp_devo='NÃO Devolvido'";
    // $sql_emprestimofinalizado = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$rm' and emp_devo='Devolvido'";
    // $sqlalunos = "SELECT * FROM alunos WHERE alu_rm='$rm'";
    // $sqlcurso = "SELECT * FROM cursos";
    // $resultado_pre = mysqli_query($conn, $sql_pre);
    // $resultado_pre2 = mysqli_query($conn, $sql_pre);
    // $resultado_pre3 = mysqli_query($conn, $sql_pre);
    // $resultado_pre4 = mysqli_query($conn, $sql_pre);
     
    // $resultado_emprestimoprogresso = mysqli_query($conn, $sql_emprestimoprogresso);
    // $resultado_emprestimofinalizado = mysqli_query($conn, $sql_emprestimofinalizado);
    // $resultadoalunos = mysqli_query($conn, $sqlalunos);
    // $resultadocurso = mysqli_query($conn, $sqlcurso);
    // $exibiralunos = mysqli_fetch_assoc($resultadoalunos);
    // $oioi = 5;
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Procura</title>
    <?php include('imports.php'); ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
    window.addEventListener("load", () => {
        var idrecebidoreload = document.getElementById('variavelid').value;
        if (idrecebidoreload == "") {
            carregou();
        };
        if (idrecebidoreload == "1") {
            btnEmprestimos()
        };
        if (idrecebidoreload == "2") {
            //btnProcurar();
        };
        if (idrecebidoreload == "3") {
            //btnNome();
        };
        if (idrecebidoreload == "4") {
            //btnNome();
        };
        if (idrecebidoreload == "99") {
            //validarfinalizacao();
        };
        // document.querySelector("#btnProcurar").addEventListener("click", e => {
        //     btnProcurar();
        // });
        // document.querySelector("#btnEmprestimos").addEventListener("click", e => {
        //     btnEmprestimos();
        //     EmpEmProgresso();
        // });
        // document.querySelector("#btnCarrinho").addEventListener("click", e => {
        //     //btnCarrinho();         
        // });
        // document.querySelector("#btnContinuarEmprestimo").addEventListener("click", e => {
        //     btnContinuarEmprestimo();
        // });
    });

    function btnEmprestimos() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Empréstimos </h3><br>
        <hr class="hrTitle"><br>
        <div class="horNav">
            <ul>
                <li id="empLi"><a onClick="ParaEntregar()"> Para Entregar </a></li>
                <li id="comLi"><a onClick="EmAtraso()"> Devolução em Atraso </a></li>
                <li id="comLi"><a onClick="Devolvido()"> Devolvidos </a></li>
            </ul>
        </div>`;
        ParaEntregar();
        document.getElementById("empLi").classList.add('navActive');
    };

    function ParaEntregar() {
        // Essas colunas são só enfeite tem que pensar noq vai colocar
        document.getElementById('main2').innerHTML = `
    <div class="empTableDiv">
        <table>
            <tr>
                <th style="width:5%;">RM</th>
                <th style="width:40%;">Titulo Livro</th>
                <th style="width:23%;">Aluno</th>
                <th style="width:17%;">Previsão Devolução</th>
                <th style="width:7,5%;">Entregar</th>
                <th style="width:7,5%;">Excluir</th>
            </tr>
            <?php     
                while ($resultadoemprestimos = mysqli_fetch_assoc($resultado)) {
                    $sql_buscatitulo = "SELECT * FROM livros WHERE liv_codi = $resultadoemprestimos[liv_codi]";
                    $resultado_buscatitulo = mysqli_query($conn, $sql_buscatitulo);
                    $exibir_buscatitulo = mysqli_fetch_assoc($resultado_buscatitulo);
                    $sql_buscaaluno = "SELECT * FROM alunos WHERE alu_rm = $resultadoemprestimos[alu_rm]";
                    $resultado_buscaaluno = mysqli_query($conn, $sql_buscaaluno);
                    $exibir_buscaaluno = mysqli_fetch_assoc($resultado_buscaaluno);
                    echo "<tr>";
                    echo "<td nome='$resultadoemprestimos[cor_codi]' id='$resultadoemprestimos[cor_codi]'> $exibir_buscaaluno[alu_rm]</td>";
                    echo "<td nome='$resultadoemprestimos[cor_codi]' id='$resultadoemprestimos[cor_codi]'> $exibir_buscatitulo[liv_titu]</td>";
                    echo "<td nome='$resultadoemprestimos[cor_codi]' id='$resultadoemprestimos[cor_codi]'> $exibir_buscaaluno[alu_nome]</td>";
                    echo "<td nome='$resultadoemprestimos[cor_codi]' id='$resultadoemprestimos[cor_codi]'> $resultadoemprestimos[emp_dtde] </td>";
                    echo "<td>
                    <a class='btnsidenav' id='$resultadoemprestimos[cor_codi]' onclick='entregar_livro($resultadoemprestimos[cor_codi], $resultadoemprestimos[liv_codi])'>
                    <img src=../img/botao_entregar.png width='20px' height='20px'>
                    </a></td>";
                    echo "<td>
                    <a class='btnsidenav' id='$resultadoemprestimos[cor_codi]' onclick='excluir_livro($resultadoemprestimos[cor_codi], $resultadoemprestimos[liv_codi])'>
                    <img src=../img/botao_excluir.png width='20px' height='20px'>
                    </a></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
    `;
        document.getElementById("empLi").classList.add('navActive');
        document.getElementById("comLi").classList.remove('navActive');
    };

    function EmAtraso() {
        document.getElementById('main2').innerHTML = `
    <div class="empTableDiv">
        <table>
            <tr>
                <th style="width:5%;">RM</th>
                <th style="width:40%;">Titulo Livro</th>
                <th style="width:23%;">Aluno</th>
                <th style="width:17%;">Previsão Devolução</th>
                <th style="width:15%;">Devolver</th>
            </tr>
            <?php 
                //while ($exibir2 = mysqli_fetch_assoc($resultado2)) {
                    $exibir2 = mysqli_fetch_assoc($resultado2);
                    $data1 = $exibir2['emp_dtde'];
                    $data2 = $datadehoje;
                    if ($data1 > $data2) {
                        echo 'Data de entrada maior que data de saida!';
                      }
                    // if($exibir2[emp_dtde] )
                    // $sql_emprestimofinalizado2 = "SELECT * FROM livros WHERE liv_codi = $exibir_emp_finalizado[liv_codi]";
                    // $resultado_produtos_sql_emprestimofinalizado2 = mysqli_query($conn, $sql_emprestimofinalizado2);
                    // $exibir_sql_emprestimofinalizado2 = mysqli_fetch_assoc($resultado_produtos_sql_emprestimofinalizado2);
                    // $sql_emprestimofinalizado3 = "SELECT * FROM emprestimo WHERE emp_codi = $exibir_emp_finalizado[emp_codi]";
                    // $resultado_produtos_sql_emprestimofinalizado3 = mysqli_query($conn, $sql_emprestimofinalizado3);
                    // $exibir_sql_emprestimofinalizado3 = mysqli_fetch_assoc($resultado_produtos_sql_emprestimofinalizado3);
                    // echo "<tr>";
                    // echo "<td nome='1' id='1'> $exibir_emp_finalizado[emp_codi]</td>";
                    // echo "<td nome='1' id='1'> $exibir_sql_emprestimofinalizado2[liv_titu]</td>";
                    // echo "<td nome='1' id='1'> $exibir_sql_emprestimofinalizado3[emp_data]</td>";
                    // echo "<td nome='1' id='1'> $exibir_emp_finalizado[cor_dtde] </td>";
                    // echo "</tr>";
                //}
            ?>
        </table>
    </div>
    `;
        document.getElementById("comLi").classList.add('navActive');
        document.getElementById("empLi").classList.remove('navActive');
    };

    function excluir_livro(idemprestimo, idlivro) {
        $.ajax({
            url: 'others/excluiremprestimo_adm.php',
            type: 'POST',
            data: {
                idemprestimo: idemprestimo,
                idlivro: idlivro
            },
            success: function(dados) {
                alert(dados);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    }

    function carregou() {
        document.getElementById('main1').innerHTML = `
        <p> Seja bem vindo a parte Administrativa do Biblietec!!</p>
        <p> Aqui vicê poderá gerenciar os empréstimos, cadastros e todas funcionalidades do sistema!!</p>
        <p> Abaixo temos um breve tutorial, para ajudar a se ambientar, ok?</p>
        <p> Clicando na nossa logo, você será redirecionado para esta tela, idependente de qual estiver</p>
        <p> Caso você clique no seu próprio nome, irá para a página de configurações do seu perfil</p>
        <p> Consultar Empréstimos - Para consultar os empréstimos em aberto para entrega, em atraso e devolvidos</p>
        <p> Cadastrar/Alterar Livros - É possível Cadastrar e Alterar os livros no sistema</p>
        <p> Alterar Cadastro Aluno - Você pode alterar o cadastro dos alunos, tais como nome, RM, etc</p>
        <p> Cadastrar Categoria/Curso - Aqui você cadastra as categorias dos livros e os cursos disponíveis na escola</p>
        <p> Sair - Volta para a página de login</p>`;
    };
    </script>

</head>

<body>
    <div class="sidenav">
        <input hidden type='text' id='datahoje' value='<?php echo date('Y-m-d');?>'>
        <input hidden type='text' id='loginadm' value='<?php echo $login;?>'>
        <input hidden type='date' id='dataemprestimo' value='<?php echo date('Y-m-d');?>'>
        <a href='home_adm.php'>
            <h1 tabindex="0" class='titulo' style='text-align: center;'><span class="cor1">Bibli</span><span
                    class="cor2">e</span><span class="cor3">tec</span></h1>
        </a>
        <hr class='full'>
        <a tabindex="1" href='home.php?id=4'><?php echo $nome ?></a><br>
        <hr class='full'>
        <?php echo '<a tabindex="2" href="home_adm.php?id=1" class="btnsidenav" id="btnProcurar">Consultar Empréstimos</a>' ?>
        <hr>
        <?php echo '<a tabindex="3" href="home_adm.php?id=2" class="btnsidenav" id="btnEmprestimos">Cadastrar/Alterar Livros</a>' ?>
        <hr>
        <?php echo '<a tabindex="4" href="home_adm.php?id=3" class="btnsidenav" id="btnCarrinho">Alterar Cadastro Aluno</a>' ?>
        <hr>
        <?php echo '<a tabindex="5" href="home_adm.php?id=4" class="btnsidenav" id="btnEmprestimos">Cadastrar Categoria/Curso</a>' ?>
        <hr>
        <a tabindex="6" class="btnsidenav" style="text-decoration:none;" href='loginadministracao.php'
            id='btnSair'>Sair</a>
    </div>
    <div class="corpoMain" id='main1'>
        <input hidden type='text' id='variavelid' value='<?php echo $idRecebido ?>'>
        <!-- FUNÇÃO DOS BOTÕES -->
        <!-- NÃO APAGAR! -->
    </div>
    <div class="corpoMain" id='main2' style='overflow-y: hidden;'>
        <input hidden type='date' id='livro1'><br>
        <input hidden type='date' id='livro2'><br>
        <input hidden type='date' id='livro3'><br>
        <!-- SOBRE O LIVRO -->
        <!-- NÃO APAGAR! -->
    </div>
    <div class="corpoMain" id='main3'>
        <!-- EXTRA - NÃO APAGAR -->
    </div>
</body>

</html>