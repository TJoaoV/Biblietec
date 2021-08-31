<?php
session_start();
$nome = $_SESSION['nome'];
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../CSS/global.css">
        <link rel="stylesheet" href="../CSS/style.css">
        <title>Biblietec - Procura</title>

        <!-- Importando fonte Roboto -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
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
                    "<h1> teste </h1>";
            };
            function btnEmprestimos(){
                document.getElementById('teste').innerHTML =
                    "<label > Emprestimos: </label>";
            };
            function btnPlaceholder(){
                document.getElementById('teste').innerHTML =
                    "<label > placeholder: </label>";
            };
        </script>
    </head>
    <body>
        <div class="sidenav">
            <h1 class='titulo' style='text-align: center;'><span class="cor1">Bibli</span><span class="cor2">e</span><span class="cor3">tec</span></h1>
            <hr class='full'>
            <a>Aluno: <?php echo $nome ?></a>
            <hr class='full'>
            <a href="" id='btnProcurar'>Procurar</a>
            <hr>
            <a href="" id='btnEmprestimos'>Empréstimos</a>
            <hr>
            <a href="" id='btnPlaceholder'>Placeholder</a>
        </div>
        <div id="main">
            <div id="teste">
                
            </div>
        </div>
    </body>
</html> 