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
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/home.css">
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
            `<label> Procurar Livros </label><br>
            <p> Selecione o Livro que deseja saber mais!</p>
            <input type="text" class="form-control pesquisa" id="inlineFormInputGroup" placeholder="Digite o nome aqui" >
            <ul class="lista">
            <?php 
                while ($exibir3 = mysqli_fetch_assoc($resultado)) {
                    $exibir4 = strtolower($exibir3['liv_titu']);
                    echo "<li class='btnsidenav' nome='$exibir4' id='$exibir3[liv_codi]'> <a onClick='VerLivro($exibir3[liv_codi])' > $exibir3[liv_titu]</li></a>";
                }
            ?>
            </ul>`;
            // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
            pesquisa_input = document.querySelectorAll(".pesquisa");    
            for(i in pesquisa_input){
                
                pesquisa_input[i].onkeyup=function(e){
                    document.getElementById('main2').innerHTML = "";
                    reg = new RegExp(this.value.toLowerCase(),"g");
                    lis = this.parentElement.querySelector(".lista");

                    console.log(lis);

                    for(j of lis.children){
                        if( !j.getAttribute("nome").match(reg) )
                            j.style.display="none";
                        else
                            j.removeAttribute("style");
                    };
                };
        };
    };

    function btnEmprestimos() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<label > Selecione o livro que quer pegar: </label>`;
    };

    function btnPlaceholder() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<label > placeholder: </label>`;
    };

    function VerLivro(id) {
        var idlivro = id;
        if(idlivro == "-"){
            document.getElementById('main2').innerHTML = "";
            alert("Selecione um livro!"); 
        }else{
            $.ajax({
                url: 'verlivro.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idlivro:idlivro,
                    tabela: 'livros'},
                success : function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<label> Nome do Livro: </label>
                        <label> `+ dados.nome + ` </label> <br><br>
                        <label> Autor: </label>
                        <label> `+ dados.autor + ` </label><br><br>
                        <label> Editora: </label>
                        <label> `+ dados.editora + ` </label><br><br>
                        <label> Categoria: </label>
                        <label> `+ dados.categoria + ` </label><br><br>
                        <label> Sinopse: </label>
                        <label> `+ dados.sinopse + ` </label>`;
                }, 
                error : function(jqXHR, textStatus) {
                    console.log('error '+ textStatus + " " + jqXHR);
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
    </div>
    <div id='main1' style='margin-left: 19rem; font-size: 28px; padding: 0px 10px;'>
        <!-- FUNÇÃO DOS BOTÕES -->
        <!-- NÃO APAGAR! -->
    </div>
    <div id='main2' style='margin-left: 19rem; font-size: 28px; padding: 0px 10px;'>
        <!-- SOBRE O LIVRO -->
        <!-- NÃO APAGAR! -->
    </div>
</body>
</html>