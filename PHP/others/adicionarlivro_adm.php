<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $titulo= $_POST['titulo'];
    $autor= $_POST['autor'];
    $editora= $_POST['editora'];
    $categoria= $_POST['categoria'];
    $sinopse= $_POST['sinopse'];
    $qtdtotal= $_POST['qtdtotal'];
    $qtddisp= $_POST['qtddisp'];
    $produtossql1 = "INSERT INTO livros (liv_titu, liv_auto, liv_edit, cat_codi, liv_sino, liv_quan, liv_qtdd) 
                    VALUES ('".$titulo."','".$autor."','".$editora."','$categoria','".$sinopse."','$qtdtotal','$qtddisp');";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    echo "Livro ".$titulo. " adicionado com sucesso!";
?>