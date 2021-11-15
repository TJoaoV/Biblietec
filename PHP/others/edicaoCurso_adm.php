<?php
    include_once("../conexao.php");
    $codi= $_POST['codi'];
    $newnomec= $_POST['newnomec'];
    $newduracao= $_POST['newduracao'];
    $oldperiodo= $_POST['oldperiodo'];
    $newperiodo= $_POST['newperiodo'];
    if ($newperiodo == "-"){
        $produtossql5 = "UPDATE cursos SET cur_nome='$newnomec', cur_dura='$newduracao' WHERE cur_codi = '$codi'";
        $resultado_produtos5 = mysqli_query($conn, $produtossql5);
        echo "Alteração concluida!";
    } else {
        $produtossql4 = "UPDATE cursos SET cur_nome='$newnomec', cur_dura='$newduracao', cur_peri='$newperiodo' WHERE cur_codi = '$codi'";
        $resultado_produtos4 = mysqli_query($conn, $produtossql4);
        echo "Alteração concluida!";
    }
    
?>