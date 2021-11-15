<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $nomeUsuADD= $_POST['nomeUsuADD'];
    $loginADD= $_POST['loginADD'];
    $cpfUsuADD= $_POST['cpfUsuADD'];
    $endeADD= $_POST['endeADD'];
    $dtnaADD= $_POST['dtnaADD'];
    $teleADD= $_POST['teleADD'];
    $celuADD= $_POST['celuADD'];
    $emailADD= $_POST['emailADD'];
    $permiADD= $_POST['permiADD'];
    $ativoADD= $_POST['ativoADD'];
    $sorteiosenha = rand(1500, 165645);
    $senhac=md5($sorteiosenha);
    $produtossql1 = "INSERT INTO usuario (usu_nome, usu_logi, usu_cpf, usu_ende, usu_dtna, usu_tele, usu_celu, usu_emai, usu_senh, usu_perm, usu_reds, usu_ativ) 
                    VALUES ('".$nomeUsuADD."','".$loginADD."','".$cpfUsuADD."','$endeADD','".$dtnaADD."','".$teleADD."','".$celuADD."','".$emailADD."','".$senhac."','".$permiADD."','1','".$ativoADD."');";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    session_start();
    include_once("../../src/PHPMailer.php");
    include_once("../../src/SMTP.php");
    include_once("../../src/Exception.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
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
        $mail->Subject = "$nomeUsuADD Adicionado!"; 
        $mail->Body = '<strong> Olá senhor(a) '.$nomeUsuADD.'</strong>! Ficamos muito contentes com sua chegada por aqui! Seu usuário foi cadastrardo no nosso sistema!<br> Sua senha temporária é: '.$sorteiosenha.' <br> Mas assim que fizer seu primeiro login no sistema poderá altera-la para uma de sua preferência!<br> <br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
        $mail->AltBody = '<strong> Olá senhor(a) '.$nomeUsuADD.'</strong>! Ficamos muito contentes com sua chegada por aqui! Seu usuário foi cadastrardo no nosso sistema!<br> Sua senha temporária é: '.$sorteiosenha.' <br> Mas assim que fizer seu primeiro login no sistema poderá altera-la para uma de sua preferência!<br> <br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
        if($mail->Send()) {
            echo "Usuário ".$nomeUsuADD. " adicionado com sucesso!";
        } else {
            echo "<h3> Email não enviado! </h3>" ;
        }
    }catch (Exception $e){
        echo "<h3> Erro ao enviar email: {$mail->ErrorInfo} </h3>";
    }
    //header("Location: home.php");
    
?>