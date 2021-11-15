<?php
    include_once("../conexao.php");
    $codi= $_POST['codi'];
    $newnomec= $_POST['newnomec'];
    $produtossql5 = "UPDATE categoria SET cat_nome='$newnomec' WHERE cat_codi = '$codi'";
    $resultado_produtos5 = mysqli_query($conn, $produtossql5);
    echo "Alteração concluida!";
    
?>