<?php
session_start();
include_once("conexao.php");
$btnLogin = filter_input(INPUT_POST, 'btnlogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	$usuario = filter_input(INPUT_POST, 'txtCPF', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);
	echo $senha."<br>";
	if((!empty($usuario)) AND (!empty($senha))){
		$senhac=md5($senha);
		$result_usuario = "SELECT * FROM alunos WHERE alu_cpf='$usuario' LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			
			if($senhac == $row_usuario['alu_senh']){
				$_SESSION['id'] = $row_usuario['alu_codi'];
				$_SESSION['rm'] = $row_usuario['alu_rm'];
				$_SESSION['nome'] = $row_usuario['alu_nome'];
				$_SESSION['telefone'] = $row_usuario['alu_tele'];
				$_SESSION['celular'] = $row_usuario['alu_celu'];
				$_SESSION['email'] = $row_usuario['alu_emai'];
				$_SESSION['datanascimento'] = $row_usuario['alu_dtna'];
				$_SESSION['codigocurso'] = $row_usuario['cur_codi'];
				$_SESSION['redefinicaosenha'] = $row_usuario['alu_reds'];
				if($_SESSION['redefinicaosenha'] == 1){
					header("Location: alterarsenhaalunos.php");
				}
				if($_SESSION['redefinicaosenha'] == 0){
					header("Location: home.php");
				}
			}else{
				$_SESSION['msg'] = "Senha ou login incorreto!";
				header("Location: error/loginalunos_error.php");
				echo "Senha incorreta";
			}
		}
	}else{
		$_SESSION['msg'] = "Senha ou Login incorreto!";
		header("Location: erro_login2.php");
		echo "Login Incorreto";
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: erro_login3.php");
	echo "Pagina nao encontrada";
}