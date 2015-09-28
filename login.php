<?php
session_start();
require_once("MySQL.class.php");

if(isset($_POST['botao'])){
	
	$conexao = new MySQL();
	$select = "SELECT id FROM casos";
	$exec = $conexao->consulta($select);
	if(count($exec) == 0){
		$xml= simplexml_load_file("ajax/xml_casos.xml");
		
		foreach($xml as $caso){
			$nivel1 = (string)$caso->nivel1;
			$nivel2 = (string)$caso->nivel2;
			$nivel3 = (string)$caso->nivel3;
			$prox 	= (string)$caso->proxima;
			$peso	= (string)$caso->peso;
			$insert = "INSERT INTO casos(nivel3,nivel2,nivel1,proxima,peso) VALUES('".$nivel3."','".$nivel2."','".$nivel1."','".$prox."','".$peso."')";
			$xml_inserted_cases = $conexao->executa($insert);
		}
	}
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