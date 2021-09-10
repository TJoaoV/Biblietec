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
    <script>
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
        <?php echo "<select name='livro'>";
        echo "<option value='-'> Selecione o Fadad </option>";
        while ($exibir = mysqli_fetch_assoc($resultado)) {
            echo "<option value='$exibir[liv_codi]'> $exibir[liv_titu] - Autor: $exibir[liv_auto]</option>";
        }?>
        <input onClick="VerLivro()" type="button" value="Ver sobre"><!-- Queria colocar um BR, mas nao consegui kkkk -->
        `;
    };

    function btnEmprestimos() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<label > Emprestimos: </label>`;
    };

    function btnPlaceholder() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
        `<label > placeholder: </label>`;
    };
    
    function VerLivro() {
        document.getElementById('main2').innerHTML =
        `<label> Nome do Livro: </label>
        <?php 
        echo "<input type='number' value='$exibir[liv_codi]'>"?>`;
        // NÃO FUNCIONOU ESTA PARTE, VERIFICAR AMANHA
    }
    </script>
</head>

<body>
    <div class="sidenav">
        <h1 class='titulo' style='text-align: center;'><span class="cor1">Bibli</span><span class="cor2">e</span><span
                class="cor3">tec</span></h1>
        <hr class='full'>
        <a>Aluno: <?php echo $nome ?></a>
        <hr class='full'>
        <a id='btnProcurar' style="cursor:pointer">Procurar</a>
        <hr>
        <a id='btnEmprestimos' style="cursor:pointer">Empréstimos</a>
        <hr>
        <a id='btnPlaceholder' style="cursor:pointer">Placeholder</a>
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