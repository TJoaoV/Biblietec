<?php
    session_start();
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../conexao.php");
    $datadehoje = date('Y-m-d');
    $rmaluno= $_POST['rmaluno'];
    $idlivro= $_POST['idlivro'];
    $devolucao= $_POST['devolucao'];
    $now= $_POST['now'];
    $ano= substr($devolucao, 0,4);
    $mes= substr($devolucao, 5,2);
    $dia= substr($devolucao, 8,2);
    $ano2= substr($datadehoje, 0,4);
    $mes2= substr($datadehoje, 5,2);
    $dia2= substr($datadehoje, 8,2);    

    $produtossql1 = "INSERT INTO corpo_emprestimo(liv_codi, emp_dtde, emp_devo, alu_rm) 
                    VALUES ('$idlivro', '$devolucao', 'NÃO Devolvido', '$rmaluno');";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);

    $produtossql3 = "DELETE FROM preemprestimo where liv_codi='$idlivro' and alu_rm='$rmaluno'";
    $resultado_produtos3 = mysqli_query($conn, $produtossql3);

    $produtossql2 = "SELECT * FROM livros WHERE liv_codi='$idlivro'";
    $resultado_produtos2 = mysqli_query($conn, $produtossql2);
    $exibir2 = mysqli_fetch_assoc($resultado_produtos2);
    $nomelivro = $exibir2['liv_titu'];

    
    include_once("../../src/PHPMailer.php");
    include_once("../../src/SMTP.php");
    include_once("../../src/Exception.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $result_usuario = "SELECT * FROM alunos WHERE alu_rm='$rmaluno' LIMIT 1";
    $resultado_usuario = mysqli_query($conn, $result_usuario);
    if($resultado_usuario){
        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
        $nome = $row_usuario['alu_nome'];
        try{
            $email = $_SESSION['email'];
            $mail = new PHPMailer(true); 
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
                $mail->Subject = "Empréstimo de $nome em $dia2/$mes2/$ano2"; 
                $mail->Body = '<strong> Olá senhor(a) '.$nome.'</strong>! É um prazer te ver por aqui usufruindo nosso sistema!<br> Você fez o empréstimo do livro '.$nomelivro.' certo? <br> Não esqueça que o prazo para devolução é '.$dia.'/'.$mes.'/'.$ano.' hein 😉<br> Caso tenha feito empréstimo de mais livros, outros e-mails irão chegar! <br><br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
                $mail->AltBody = '<strong> Olá senhor(a) '.$nome.'</strong>! É um prazer te ver por aqui usufruindo nosso sistema!<br> Você fez o empréstimo do livro '.$nomelivro.' certo? <br> Não esqueça que o prazo para devolução é '.$dia.'/'.$mes.'/'.$ano.' hein 😉<br> Caso tenha feito empréstimo de mais livros, outros e-mails irão chegar! <br><br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
                if($mail->Send()) {
                    echo "Livro ".$nomelivro." adicionado a reserva!";
                } else {
                    echo "<h3> Email nao enviado! </h3>" ;
                }
            }catch (Exception $e){
                echo "<h3> Erro ao enviar email: {$mail->ErrorInfo} </h3>";
            }
        } catch (Exception $e) {
            echo "<h3> ERROR! </h3>";
        }
    }else{
        echo "Dados informados incorretamente!";
    }
      
?>