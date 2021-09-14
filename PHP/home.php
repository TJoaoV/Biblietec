<?php
session_start();
$nome = $_SESSION['nome'];
$rm = $_SESSION['rm'];
include_once("conexao.php");
$sql = "SELECT * FROM livros";
$sql_pre = "SELECT * FROM preemprestimo WHERE alu_rm='$rm'";
$resultado = mysqli_query($conn, $sql);
$resultado_pre = mysqli_query($conn, $sql_pre);
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Procura</title>
    <?php include('imports.php'); ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
    window.addEventListener("load", () => {
        document.querySelector("#btnProcurar").addEventListener("click", e => {
            btnProcurar();
        });
        document.querySelector("#btnEmprestimos").addEventListener("click", e => {
            btnEmprestimos();
            EmpEmProgresso();
        });
        document.querySelector("#btnCarrinho").addEventListener("click", e => {
            btnCarrinho();
        });
        document.querySelector("#btnPlaceholder").addEventListener("click", e => {
            btnPlaceholder();
        });
    });

    function btnCarrinho(){
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML = `
        <h2> Carrinho</h2>
        <table style="border:1px solid black" name='carrinhotable' id='carrinhotable'>
            <tr style="border:1px solid black">
                <th width="5%" style="border:1px solid black">Id</th>
                <th width="35%" style="border:1px solid black">Titulo</th>
                <th width="25%" style="border:1px solid black">Autor</th>
                <th width="15%" style="border:1px solid black">Data Empréstimo</th>
                <th width="15%" style="border:1px solid black">Data Entrega</th>
                <th width="5%" style="border:1px solid black"></th>
            </tr>
            <?php 

                while ($exibir_pre = mysqli_fetch_assoc($resultado_pre)) {
                    echo "<tr>";
                   //$exibir2_pre = strtolower($resultado_pre['liv_titu']);
                    echo "<th>$exibir_pre[liv_codi]</th>";
                    echo "<th>$exibir_pre[liv_codi]</th>";
                    echo "<th>$exibir_pre[liv_codi]</th>";
                    echo "<th>$exibir_pre[pre_data]</th>";
                    echo "<th> </th>";
                    //echo "<th class='listaOpcao' nome='$exibir_pre[liv_codi]' id='$exibir_pre[liv_codi]'> $exibir3[liv_titu]</th>";
                    echo "</tr>";
                }
            ?>
        </table>`;
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

    function btnPlaceholder() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<label > placeholder: </label>`;
    };

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
                        <input type='button' onClick ='fazerReserva(`+dados.codigo+`)' value='Adicionar no Carrinho' id='btnAddCarrinho'>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function fazerReserva(codigo){
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
                // document.getElementById('main2').innerHTML =
                //     `<div class="result">
                //     <hr>
                //     <label><b> Código do Livro: </b></label>
                //     <label> ` + dados.codigo + ` </label> <br>
                //     <label><b> Título do Livro: </b></label>
                //     <label> ` + dados.nome + ` </label> <br>
                //     <label><b> Autor: </b></label>
                //     <label> ` + dados.autor + ` </label><br>
                //     <label><b> Editora: </b></label>
                //     <label> ` + dados.editora + ` </label><br>
                //     <label><b> Categoria: </b></label>
                //     <label> ` + dados.categoria + ` </label><br>
                //     <label><b> Sinopse: </b></label>
                //     <label> ` + dados.sinopse + ` </label>
                //     <input type='button' onClick ='fazerReserva(`+dados.codigo+`)' value='Adicionar no Carrinho' id='btnAddCarrinho'>
                //     </div>`;
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
        <h1 class='titulo' style='text-align: center;'><span class="cor1">Bibli</span><span class="cor2">e</span><span
                class="cor3">tec</span></h1>
        <hr class='full'>
        <a>Aluno: <?php echo $nome ?></a>
        <input type="text" id='rmcontent' name='rmcontent' value ='<?php echo $rm ?>' hidden>
        <hr class='full'>
        <a class="btnsidenav" id='btnProcurar'>Procurar</a>
        <hr>
        <a class="btnsidenav" id='btnEmprestimos'>Empréstimos</a>
        <hr>
        <a class="btnsidenav" id='btnPlaceholder'>Placeholder</a>
        <hr>
        <a class="btnsidenav" id='btnCarrinho'>Carrinho</a>
        <hr>
        <a class="btnsidenav" style="text-decoration:none;" href='../index.php' id='btnSair'>Sair</a>
    </div>
    <div class="corpoMain" id='main1'>
        <p> Seja bem vindo a Biblietec!!</p>
        <p> Aqui você poderá fazer a reserva do seu livro, para depois apenas pega-lo na bilioteca!!</p>
        <p> Abaixo temos um breve tutorial, para ajudar a se ambientar no sistema, ok?</p>
        <p> Caso você clique no seu próprio nome, irá para a página de configurações do seu perfil</p>
        <p> Procurar - Para navegar e caso queira, adicionar no carrinho o(s) livro(s) selecionado(s)</p>
        <p> Empréstimos - É possível verificar todos seus empréstimos feitos, em andamento e Finalizados</p>
        <p> Carrinho - Lá você pode ver o(s) livro(s) que você adicionou no carrinho de empréstimo</p>
        <p> Sair - Volta para a página de login</p>
        <!-- FUNÇÃO DOS BOTÕES -->
        <!-- NÃO APAGAR! -->
    </div>
    <div class="corpoMain" id='main2' style='overflow-y: hidden;'>
        <!-- SOBRE O LIVRO -->
        <!-- NÃO APAGAR! -->
    </div>
</body>

</html>