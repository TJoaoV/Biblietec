<?php
    include_once("../conexao.php");
    $rmaluno= $_POST['rmaluno'];
    $newtelefone= $_POST['newtelefone'];
    $newcelular= $_POST['newcelular'];
    $newemail= $_POST['newemail'];
    $newcurso= $_POST['newcurso'];
    $produtossql4 = "UPDATE alunos SET alu_tele='$newtelefone', alu_celu='$newcelular', alu_emai='$newemail', cur_codi='$newcurso' WHERE alu_rm = '$rmaluno'";
    $resultado_produtos4 = mysqli_query($conn, $produtossql4);
    echo "Alteração concluida!";
?>