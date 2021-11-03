<?php
    include_once("../conexao.php");
    $usuario_adm= $_POST['usuario_adm'];
    $newnome= $_POST['newnome'];
    $newusuario= $_POST['newusuario'];
    $newtelefone= $_POST['newtelefone'];
    $newcelular= $_POST['newcelular'];
    $newemail= $_POST['newemail'];
    $newendereco= $_POST['newendereco'];
    $produtossql4 = "UPDATE usuario SET usu_tele='$newtelefone', usu_celu='$newcelular', usu_emai='$newemail', usu_nome='$newnome', usu_logi='$newusuario', usu_ende='$newendereco' WHERE usu_codi = '$usuario_adm'";
    $resultado_produtos4 = mysqli_query($conn, $produtossql4);
    echo "Alteração concluida!";
?>