<?php
session_start();
require_once("MySQL.class.php");

if(isset($_POST['botao'])){
	
	$conexao = new MySQL();
	$query = "SELECT id FROM usuarios WHERE login='".$_POST['login']."' AND senha='".md5($_POST['senha'])."'";
	
	$resultado = $conexao->consulta($query);
	
	if(count($resultado)){//tem resultados (login e senha corretos)
		$id = $resultado[0]['id'];
		$_SESSION['id'] = $id;
		header("location: index.php");
		exit;
	}else{
		echo "Login ou senha incorretos";
	}
}

?>

<html>

	<body>
	
		<form method="post">
			<h1>Login</h1>
			Login: <input type="text" name="login"><br>
			Senha: <input type="password" name="senha"><br>
			<input type="submit" name="botao" value="Login">
		</form>
	
	</body>

</html>