<?php
session_start();
$nome = $_SESSION['nome'];
include_once("conexao.php");
$sql = "SELECT * FROM livros";
$resultado = mysqli_query($conn, $sql);
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
        });
        document.querySelector("#btnPlaceholder").addEventListener("click", e => {
            btnPlaceholder();
        });
    });

    function btnProcurar() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Livros </h3><br><hr class="hrTitle"><br>
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
            `<label > Veja seus empréstimos abaixo: </label><br>
            <a onClick="EmpEmProgresso()"> Em Progresso </a><br>
            <a onClick="EmpCompleto()"> Completo </a><br>`;
    };
    function EmpEmProgresso() {
        document.getElementById('main2').innerHTML = `
        <table>
        </table>`;
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
                url: 'verlivro.php',
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
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };
    </script>
</head>

<body>
    <div class="sidenav">
        <h1 class='titulo' style='text-align: center;'><span class="cor1">Bibli</span><span class="cor2">e</span><span
                class="cor3">tec</span></h1>
        <hr class='full'>
        <a>Aluno: <?php echo $nome ?></a>
        <hr class='full'>
        <a class="btnsidenav" id='btnProcurar'>Procurar</a>
        <hr>
        <a class="btnsidenav" id='btnEmprestimos'>Empréstimos</a>
        <hr>
        <a class="btnsidenav" id='btnPlaceholder'>Placeholder</a>
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