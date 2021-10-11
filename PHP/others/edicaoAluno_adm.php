<?php
    include_once("../conexao.php");
    $codi= $_POST['codi'];
    $newrm= $_POST['newrm'];
    $newnome= $_POST['newnome'];
    $newcpf= $_POST['newcpf'];
    $newtelefone= $_POST['newtelefone'];
    $newcelular= $_POST['newcelular'];
    $newemail= $_POST['newemail'];
    $newdtnas= $_POST['newdtnas'];
    $oldcurso= $_POST['oldcurso'];
    $newcurso= $_POST['newcurso'];
    if ($newcurso == "-"){
        $produtossql5 = "UPDATE alunos SET alu_rm='$newrm', alu_nome='$newnome', alu_cpf='$newcpf', alu_tele='$newtelefone', alu_celu='$newcelular', alu_emai='$newemail', alu_dtna='$newdtnas' , cur_codi='$oldcurso' WHERE alu_codi = '$codi'";
        $resultado_produtos5 = mysqli_query($conn, $produtossql5);
        echo "Alteração concluida!";
    } else {
        $produtossql4 = "UPDATE alunos SET alu_rm='$newrm', alu_nome='$newnome', alu_cpf='$newcpf', alu_tele='$newtelefone', alu_celu='$newcelular', alu_emai='$newemail', alu_dtna='$newdtnas' , cur_codi='$newcurso' WHERE alu_codi = '$codi'";
        $resultado_produtos4 = mysqli_query($conn, $produtossql4);
        echo "Alteração concluida!";
    }
    
?>