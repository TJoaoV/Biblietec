<?php
    session_start();
    try{
        $idRecebido = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    } catch (Exception $e){
    };
    $nome = $_SESSION['nome'];
    $rm = $_SESSION['rm'];
    require("conexao.php");
    $sql = "SELECT * FROM livros";
    $sql_pre = "SELECT * FROM preemprestimo WHERE alu_rm='$rm'";
    $resultado_pre = mysqli_query($conn, $sql_pre);
    $resultado_pre2 = mysqli_query($conn, $sql_pre);
    $resultado_pre3 = mysqli_query($conn, $sql_pre);
    $resultado_pre4 = mysqli_query($conn, $sql_pre);
    $resultado = mysqli_query($conn, $sql);
    $oioi = 5;
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Procura</title>
    <?php include('imports.php'); ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
    window.addEventListener("load", () => {
        var idrecebidoreload = document.getElementById('variavelid').value;
        if (idrecebidoreload == "") {
            carregou();
        };
        if (idrecebidoreload == "2") {
            btnCarrinho();
        };
        if (idrecebidoreload == "99") {
            validarfinalizacao();
        };
        document.querySelector("#btnProcurar").addEventListener("click", e => {
            btnProcurar();
        });
        document.querySelector("#btnEmprestimos").addEventListener("click", e => {
            btnEmprestimos();
            EmpEmProgresso();
        });
        document.querySelector("#btnCarrinho").addEventListener("click", e => {
            //btnCarrinho();         
        });
        document.querySelector("#btnPlaceholder").addEventListener("click", e => {
            btnPlaceholder();
        });
        document.querySelector("#btnContinuarEmprestimo").addEventListener("click", e => {
            btnContinuarEmprestimo();
        });
    });

    function validarfinalizacao() {
        const now = new Date();
        var livro1;
        var livro2;
        var livro3;
        try {
            var livro1 = document.getElementById('livro1').value;
            const past1 = new Date(livro1);
            const diff1 = Math.abs(now.getTime() - past1.getTime());
            const days1 = Math.ceil(diff1 / (1000 * 60 * 60 * 24));
            if (days1 <= 30) {
                alert('tacerto');
            } else {
                alert('O Prazo máximo para devolução do livro é de 30 dias!');
            }
        } catch {};
        try {

            var livro2 = document.getElementById('livro2').value;
            const past2 = new Date(livro2);
            const diff2 = Math.abs(now.getTime() - past2.getTime());
            const days2 = Math.ceil(diff2 / (1000 * 60 * 60 * 24));
            if (days2 <= 30) {
                alert('tacerto');
            } else {
                alert('O Prazo máximo para devolução do livro é de 30 dias!');
            }
        } catch {};
        try {
            var livro3 = document.getElementById('livro3').value;
            const past3 = new Date(livro3);
            const diff3 = Math.abs(now.getTime() - past3.getTime());
            const days3 = Math.ceil(diff3 / (1000 * 60 * 60 * 24));
            if (days3 <= 30) {
                alert('tacerto');
            } else {
                alert('O Prazo máximo para devolução do livro é de 30 dias!');
            }
        } catch {};
    };

    function carregou() {
        document.getElementById('main1').innerHTML = `
        <p> Seja bem vindo a Biblietec!!</p>
        <p> Aqui você poderá fazer a reserva do seu livro, para depois apenas pega-lo na bilioteca!!</p>
        <p> Abaixo temos um breve tutorial, para ajudar a se ambientar no sistema, ok?</p>
        <p> Caso você clique no seu próprio nome, irá para a página de configurações do seu perfil</p>
        <p> Procurar - Para navegar e caso queira, adicionar no carrinho o(s) livro(s) selecionado(s)</p>
        <p> Empréstimos - É possível verificar todos seus empréstimos feitos, em andamento e Finalizados</p>
        <p> Carrinho - Lá você pode ver o(s) livro(s) que você adicionou no carrinho de empréstimo</p>
        <p> Sair - Volta para a página de login</p>`;
    }

    function btnCarrinho() {
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML = `
        <h3 class="corpoTitle"> Carrinho</h3><br>
        <hr class="hrTitle"><br>
        <div class="empTableDiv">
        <table name='carrinhotable' id='carrinhotable'>
            <tr>
                <th width="5%">Id</th>
                <th width="35%">Titulo</th>
                <th width="25%">Autor</th>
                <th width="15%">Data Reserva</th>
                <th width="5%"></th>
            </tr>
            <?php 
                while ($exibir_pre = mysqli_fetch_assoc($resultado_pre)) {
                    $sql_buscalista = "SELECT * FROM livros WHERE liv_codi='$exibir_pre[liv_codi]'";
                    $resultado_buscalista = mysqli_query($conn, $sql_buscalista);
                    $exibir_buscalista = mysqli_fetch_assoc($resultado_buscalista);
                    echo "<tr>";
                    echo "<td>$exibir_pre[liv_codi]</td>";
                    echo "<td>$exibir_buscalista[liv_titu]</td>";
                    echo "<td>$exibir_buscalista[liv_auto]</td>";
                    echo "<td>$exibir_pre[pre_data]</td>";
                    echo "<td>
                    <a class='btnsidenav' id='$exibir_pre[pre_codi]' onclick='remover_livro($exibir_pre[pre_codi])'>
                    <img src=../img/botao_excluir.png width='20px' height='20px'>
                    </a></td></tr>";
                }
            ?>
        </table>
        </div>
        <div class='alinharmeio botpage'>
        <button tabindex='0' href='#' class='botVerm botinpage pointer' onclick='btnContinuarEmprestimo()'> Continuar com a reserva </button>
        </div>`;
    };

    function btnContinuarEmprestimo() {
        document.getElementById('main2').innerHTML = `
        <div class='alinharmeio fundoBranco' style='border-radius: 1vh 1vh;'>
        <h3 style='padding-top: 3vh; margin-bottom: -1vh;'> Selecione as datas para devolução (máximo 30 dias): </h3><br>
        <?php
            $datadehoje = date('Y-m-d');
            $a = 1;
            while ($exibir_pre2 = mysqli_fetch_assoc($resultado_pre2)){
                $sql_buscalista2 = "SELECT * FROM livros WHERE liv_codi='$exibir_pre2[liv_codi]'";
                $resultado_buscalista2 = mysqli_query($conn, $sql_buscalista2);
                $exibir_buscalista2 = mysqli_fetch_assoc($resultado_buscalista2);
                echo "<label><b> $exibir_buscalista2[liv_titu] </b></label><br>";
                echo "<input  style='margin-bottom: 2vh; width: 30%;' type='date' min='$datadehoje' id='livro$a'><br>";
                $a++;
            }
        ?>
        <button tabindex="0" href='#' class='botVerm textdecor botinpage' onClick='validarfinalizacao();' id='btnContinuarEmprestimo'> Finalizar Reserva </button>
        </div>`;
    };

    function remover_livro(id) {
        var idtable = id;
        $.ajax({
            url: 'others/removerlivro.php',
            type: 'POST',
            data: {
                idtable: idtable
            },
            success: function(removerlivromsg) {
                window.location.reload();
                alert(removerlivromsg);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function btnProcurar() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Livros </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Selecione o Livro que deseja saber mais!</b></p>
            <input class="form-control pesquisa corpoInputtxt" type="text" id="inlineFormInputGroup" placeholder="Digite o nome aqui!" >
            <table>
            <ul class="lista" style="list-style-type:none;  ">
            <?php 
                while ($exibir3 = mysqli_fetch_assoc($resultado)) {
                    $exibir4 = strtolower($exibir3['liv_titu']);
                    echo "<li class='listaOpcao' onClick='VerLivro($exibir3[liv_codi])' nome='$exibir4' id='$exibir3[liv_codi]'> $exibir3[liv_titu]</li>";
                }
            ?>
            </ul>
            </table>`;
        // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
        pesquisa_input = document.querySelectorAll(".pesquisa");
        for (i in pesquisa_input) {
            pesquisa_input[i].onkeyup = function(e) {
                document.getElementById('main2').innerHTML = "";
                reg = new RegExp(this.value.toLowerCase(), "g");
                lis = this.parentElement.querySelector(".lista");
                //console.log(lis);
                for (j of lis.children) {
                    if (!j.getAttribute("nome").match(reg))
                        j.style.display = "none";
                    else
                        j.removeAttribute("style");
                };
            };
        };
    };

    function btnEmprestimos() {

        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Empréstimos </h3><br>
            <hr class="hrTitle"><br>
            <div class="horNav">
                <ul>
                    <li id="empLi"><a onClick="EmpEmProgresso()"> Em Progresso </a></li>
                    <li id="comLi"><a onClick="EmpCompleto()"> Completo </a></li>
                </ul>
            </div>`;

    };

    function EmpEmProgresso() {
        // Essas colunas são só enfeite tem que pensar noq vai colocar
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th style="width:10%;">ID</th>
                    <th style="width:60%;">Título</th>
                    <th style="width:30%;">Data</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>O Pequeno Principe</td>
                    <td>15/03/2000</td>
                </tr>
            </table>
        </div>
        `;
        document.getElementById("empLi").classList.add('navActive');
        document.getElementById("comLi").classList.remove('navActive');
    }

    function EmpCompleto() {
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th>Placeholder2</th>
                    <th>Placeholder2</th>
                    <th>Placeholder2</th>
                </tr>
                <tr>
                    <td>Placeholder2</td>
                    <td>Placeholder2</td>
                    <td>Placeholder2</td>
                </tr>
            </table>
        </div>
        `;
        document.getElementById("comLi").classList.add('navActive');
        document.getElementById("empLi").classList.remove('navActive');
    }

    function VerLivro(id) {
        var idlivro = id;
        if (idlivro == "-") {
            document.getElementById('main2').innerHTML = "";
            alert("Selecione um livro!");
        } else {
            $.ajax({
                url: 'others/verlivro.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idlivro: idlivro,
                    tabela: 'livros'
                },
                success: function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<div class="result">
                        <hr>
                        <label><b> Código do Livro: </b></label>
                        <label> ` + dados.codigo + ` </label> <br>
                        <label><b> Título do Livro: </b></label>
                        <label> ` + dados.nome + ` </label> <br>
                        <label><b> Autor: </b></label>
                        <label> ` + dados.autor + ` </label><br>
                        <label><b> Editora: </b></label>
                        <label> ` + dados.editora + ` </label><br>
                        <label><b> Categoria: </b></label>
                        <label> ` + dados.categoria + ` </label><br>
                        <label><b> Sinopse: </b></label>
                        <label> ` + dados.sinopse + ` </label>
                        <input type='button' onClick ='fazerReserva(` + dados.codigo + `)' value='Adicionar no Carrinho' id='btnAddCarrinho'>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function fazerReserva(codigo) {
        var idlivr = codigo;
        var alunorm = document.getElementById('rmcontent').value;
        $.ajax({
            url: 'others/prereserva.php',
            type: 'POST',
            data: {
                idlivro: idlivr,
                alunorm: alunorm,
            },
            success: function(dados) {
                alert(dados);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };
    </script>
</head>

<body>
    <div class="sidenav">
        <h1 tabindex="0" href='#' class='titulo' style='text-align: center;'><span class="cor1">Bibli</span><span
                class="cor2">e</span><span class="cor3">tec</span></h1>
        <hr class='full'>
        <a tabindex="1" href='#'>Aluno: <?php echo $nome ?></a>
        <input type="text" id='rmcontent' name='rmcontent' value='<?php echo $rm ?>' hidden>
        <hr class='full'>
        <a tabindex="2" href='#' class="btnsidenav" id='btnProcurar'>Procurar</a>
        <hr>
        <a tabindex="3" href='#' class="btnsidenav" id='btnEmprestimos'>Empréstimos</a>
        <hr>
        <?php echo '<a tabindex="5" href="home.php?id=2" class="btnsidenav" id="btnCarrinho">Carrinho</a>' ?>
        <hr>
        <a tabindex="6" class="btnsidenav" style="text-decoration:none;" href='../index.php' id='btnSair'>Sair</a>
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
        <input hidden type='text' id='datahoje' value='<?php echo date('Y-m-d');?>'>
        <!-- EXTRA - NÃO APAGAR -->
    </div>
</body>

</html>