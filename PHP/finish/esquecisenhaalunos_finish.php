<!DOCTYPE html>
<html lang="PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
</head>
<body>
<?php
session_start();
include_once("../../src/PHPMailer.php");
include_once("../../src/SMTP.php");
include_once("../../src/Exception.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include_once("../conexao.php");
$btncontinuar = filter_input(INPUT_POST, 'btncontinuar', FILTER_SANITIZE_STRING);
if($btncontinuar){
	$nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
	$CPF = filter_input(INPUT_POST, 'txtCPF', FILTER_SANITIZE_STRING);
    $RM = filter_input(INPUT_POST, 'txtRM', FILTER_SANITIZE_STRING);
	//echo $senha."<br>";
    $result_usuario = "SELECT * FROM alunos WHERE alu_cpf='$CPF' LIMIT 1";
    $resultado_usuario = mysqli_query($conn, $result_usuario);
    if($resultado_usuario){
        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
        try{
            $_SESSION['cpf'] = $row_usuario['alu_cpf'];
            $_SESSION['nome'] = $row_usuario['alu_nome'];
            $_SESSION['rm'] = $row_usuario['alu_rm'];
            if($CPF == $_SESSION['cpf'] and $nome == $_SESSION['nome'] and $RM == $_SESSION['rm']){
                $_SESSION['email'] = $row_usuario['alu_emai'];
                $email = $_SESSION['email'];
                $_SESSION['id'] = $row_usuario['alu_codi'];
                $id = $_SESSION['id'];
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
                    $mail->Subject = "Redefinir senha $nome"; 
                    $mail->Body = '<strong> Olá senhor(a) '.$nome.'</strong>! É um prazer te ver por aqui, vamos redefinir esta senha então?<br> Sua nova senha é: 1234 <br> Mas não se esqueça que assim que fizer login terá que altera-la, ok?<br> <br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
                    $mail->AltBody = 'Olá senhor(a) '.$nome.'! É um prazer te ver por aqui, vamos redefinir esta senha então?<br> Sua nova senha é: 1234 <br> Mas não se esqueça que assim que fizer login terá que altera-la, ok?<br> <br> Estamos a disposição para qualquer dúvida, até mais!!<br> Atenciosamente, Sistema BibliEtec ';
                    if($mail->Send()) {
                        $senhac=md5('1234');
                        $sql = "UPDATE alunos SET alu_senh='$senhac', alu_reds='1' WHERE alu_codi = '$id'";
                        $resultadoupdate = mysqli_query($conn, $sql);
                        echo "Email de Redefinição de senha enviado com sucesso!"; 
                    } else {
                        echo "Email nao enviado!";
                    }
                }catch (Exception $e){
                    echo "Erro ao enviar email: {$mail->ErrorInfo}";
                }
                //header("Location: home.php");
            }else{
                $_SESSION['msg'] = "Dados informados incorretamente! Verifique e tente novamente!";
                echo "Dados informados incorretamente! Verifique e tente novamente!";
            }
        } catch (Exception $e) {
            $_SESSION['msg'] = "Dados informados incorretamente! Verifique e tente novamente!";
            echo "Dados informados incorretamente! Verifique e tente novamente!";
        }
    }else{
        $_SESSION['msg'] = "Dados informados incorretamente!";
        echo "Dados informados incorretamente!";
    }
}else{
	$_SESSION['msg'] = "Error!";
	echo "Error!";
}
?>
<input id='btnvoltar' type='button' name='btnvoltar' value='Voltar' onClick="location.href = '../../index.html';">
</body>
</html>
