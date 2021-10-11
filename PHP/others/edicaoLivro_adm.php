<?php
    include_once("../conexao.php");
    $neweditora= $_POST['neweditora'];
    $oldcategoria= $_POST['oldcategoria'];
    $newcategoria= $_POST['newcategoria'];
    $newsinopse= $_POST['newsinopse'];
    $newqtdtotal= $_POST['newqtdtotal'];
    $newqtddisp= $_POST['newqtddisp'];
    $idlivro= $_POST['idlivro'];
    if ($newcategoria == "-"){
        $produtossql4 = "UPDATE livros SET liv_edit='$neweditora', cat_codi='$oldcategoria', liv_sino='$newsinopse', liv_quan='$newqtdtotal', liv_qtdd='$newqtddisp' WHERE liv_codi = '$idlivro'";
        $resultado_produtos4 = mysqli_query($conn, $produtossql4);
        echo "Alteração concluida!";
    } else {
        $produtossql4 = "UPDATE livros SET liv_edit='$neweditora', cat_codi='$newcategoria', liv_sino='$newsinopse', liv_quan='$newqtdtotal', liv_qtdd='$newqtddisp' WHERE liv_codi = '$idlivro'";
        $resultado_produtos4 = mysqli_query($conn, $produtossql4);
        echo "Alteração concluida!";
    }
    
?>