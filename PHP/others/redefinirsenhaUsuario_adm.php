<?php
    include_once("../conexao.php");
    include_once("../../src/PHPMailer.php");
    include_once("../../src/SMTP.php");
    include_once("../../src/Exception.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    session_start();
    $idUsuario= $_POST['idUsuario'];
    $senha= $_POST['senha'];
    $usuarioadm= $_POST['usuarioadm'];
    $sql = "SELECT * FROM usuario WHERE usu_codi='$usuarioadm'";
    $resultado = mysqli_query($conn, $sql);
    $resultadosenha = mysqli_fetch_assoc($resultado);
    $senhacrip = md5($senha);
    if($resultadosenha['usu_senh'] == $senhacrip){
        $sql2 = "SELECT * FROM usuario WHERE usu_codi='$idUsuario'";
        $resultado2 = mysqli_query($conn, $sql2);
        $resultadoaluno = mysqli_fetch_assoc($resultado2);
        $nome = $resultadoaluno['usu_nome'];
        $email = $resultadoaluno['usu_emai'];
        $mail = new PHPMailer(true); 
        $sorteiosenha = rand(1500, 165645);
        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->IsSMTP(); 
            $mail->Host = "smtp.gmail.com"; 
            $mail->Port = 587; 
            $mail->SMTPAuth = true; 
            $mail->Username = 'naorespondabiblietec@gmail.com'; 
            $mail->Password = 'biblietec123'; 
            //$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) ); 
            //$mail->SMTPDebug = 2; 
            $mail->From = "naorespondabiblietec@gmail.com";
            $mail->FromName = "Biblietec"; 
            $mail->AddAddress($email, $nome);
            // Opcional: mais de um destinatário
            // $mail->AddAddress('fernando@email.com'); 
            // Opcionais: CC e BCC
            // $mail->AddCC('joana@provedor.com', 'Joana'); 
            // $mail->AddBCC('roberto@gmail.com', 'Roberto'); 
            $mail->IsHTML(true); 
            $mail->CharSet = 'UTF-8'; 
            $mail->Subject = "Redefinir senha $nome"; 
            $mail->Body = '<strong> Olá senhor(a) '.$nome.'</strong>! É um prazer te ver por aqui, vamos redefinir esta senha então?<br> Sua nova senha é: '.$sorteiosenha.' <br> Mas não se esqueça que assim que fizer login terá que altera-la, ok?<br> <br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
            $mail->AltBody = 'Olá senhor(a) '.$nome.'! É um prazer te ver por aqui, vamos redefinir esta senha então?<br> Sua nova senha é: '.$sorteiosenha.' <br> Mas não se esqueça que assim que fizer login terá que altera-la, ok?<br> <br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
            if($mail->Send()) {
                $novasenhausu = md5($sorteiosenha);
                $sql = "UPDATE usuario SET usu_senh='$novasenhausu', usu_reds='1' WHERE usu_codi = '$idUsuario'";
                $resultadoupdate = mysqli_query($conn, $sql);
                echo "Email de Redefinição de senha enviado com sucesso!"; 
            } else {
                echo "Email não enviado! " ;
            }
        }catch (Exception $e){
            echo "Erro ao enviar email: {$mail->ErrorInfo}";
        };
    } else {
        echo "Senha incorreta!";
    };
?>