<?php
session_start();
$nome = $_SESSION['nome'];
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
        document.getElementById('teste').innerHTML =
            "<label> Quantidade Prestações: </label>" +
            "<h1> teste </h1>";
    };

    function btnEmprestimos() {
        document.getElementById('teste').innerHTML =
            "<label > Emprestimos: </label>";
    };

    function btnPlaceholder() {
        document.getElementById('teste').innerHTML =
            "<label > placeholder: </label>";
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
        <a id='btnProcurar' style="cursor:pointer">Procurar</a>
        <hr>
        <a id='btnEmprestimos' style="cursor:pointer">Empréstimos</a>
        <hr>
        <a id='btnPlaceholder' style="cursor:pointer">Placeholder</a>
    </div>
    <div id='teste' style='margin-left: 19rem; font-size: 28px; padding: 0px 10px;'>

    </div>
</body>

</html>