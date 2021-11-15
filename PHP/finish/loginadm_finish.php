<?php
session_start();
include_once("../conexao.php");
$btnLogin = filter_input(INPUT_POST, 'btnlogin', FILTER_SANITIZE_STRING);
if($btnLogin){
	$usuario = filter_input(INPUT_POST, 'txtusuario', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);
	if((!empty($usuario)) AND (!empty($senha))){
		$senhac=md5($senha);
		$result_usuario = "SELECT * FROM usuario WHERE usu_logi='$usuario' LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			
			if($senhac == $row_usuario['usu_senh']){
				$_SESSION['id'] = $row_usuario['usu_codi'];
				$_SESSION['nome'] = $row_usuario['usu_nome'];
				$_SESSION['usuario'] = $row_usuario['usu_logi'];
				$_SESSION['email'] = $row_usuario['usu_emai'];
				$_SESSION['permissao'] = $row_usuario['usu_perm'];
				$_SESSION['ativo'] = $row_usuario['usu_ativ'];
				$_SESSION['redefinicaosenha'] = $row_usuario['usu_reds'];
				if($_SESSION['redefinicaosenha'] == 1){
					header("Location: ../others/alterarsenhaadm.php");
				}
				if($_SESSION['redefinicaosenha'] == 0){
					header("Location: ../home_adm.php");
				}
				if($_SESSION['ativo'] == 0){
					$_SESSION['msg'] = "Usuário Inativo!";
					header("Location: ../error/loginadm_error.php");
					echo "ERROR!";
				}
			}else{
				$_SESSION['msg'] = "Senha ou login incorreto!";
				header("Location: ../error/loginadm_error.php");
				echo "Senha incorreta";
			}
		}
	}else{
		$_SESSION['msg'] = "Senha ou Login incorreto!";
		header("Location: ../error/loginadm_error.php");
		echo "Login Incorreto";
	}
}else{
	$_SESSION['msg'] = "Página não encontrada";
	header("Location: ../error/loginadm_error.php");
	echo "Pagina nao encontrada";
}