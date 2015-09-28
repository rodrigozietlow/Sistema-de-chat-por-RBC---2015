<?phpheader('Content-Type: text/html; charset=ISO-8859-1');$_POST = array_map('strtolower', $_POST);
require_once($_SERVER['DOCUMENT_ROOT']."/Sistema-de-chat-por-RBC---2015/MySQL.class.php");

$tipo = $_POST['tipo'];
if($tipo == 1){
	$nivel1 = $_POST['nivel1'];
	$proximo = $_POST['proxima'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT id FROM casos WHERE nivel3 is NULL AND nivel2 IS NULL AND nivel1='$nivel1' AND proxima = '$proximo'";
	$resultado = $conexao->consulta($queryVerificacao);
	
	if(count($resultado)>0){ //existe -> soma
		$id = $resultado[0]['id'];
		$query = "UPDATE casos SET peso = peso+1 WHERE id=$id";
	}
	else{
		$query = "INSERT INTO casos(nivel1, proxima, peso) VALUES('$nivel1', '$proximo', 1)";				
	}
	
	$conexao->executa($query);
}
else if($tipo == 2){
	$nivel2 = $_POST['nivel2'];
	$nivel1 = $_POST['nivel1'];
	$proximo = $_POST['proxima'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT id FROM casos WHERE nivel3 is NULL AND nivel1='$nivel1' AND nivel2='$nivel2'  AND proxima = '$proximo'";
	$resultado = $conexao->consulta($queryVerificacao);
	
	if(count($resultado)>0){ //existe -> soma
		$id = $resultado['id'];
		$query = "UPDATE casos SET peso = peso+2 WHERE id=$id";
	}
	else{
		$query = "INSERT INTO casos(nivel2, nivel1, proxima, peso) VALUES('$nivel2', '$nivel1', '$proximo', 2)";		
	}
	
	$conexao->executa($query);
}
else if($tipo == 3){
	$nivel3 = $_POST['nivel3'];
	$nivel2 = $_POST['nivel2'];
	$nivel1 = $_POST['nivel1'];
	$proximo = $_POST['proxima'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT id FROM casos WHERE nivel3='$nivel3' AND nivel1='$nivel1' AND nivel2='$nivel2' AND proxima = '$proximo'";
	$resultado = $conexao->consulta($queryVerificacao);
	
	if(count($resultado)>0){ //existe -> soma
		$id = $resultado['id'];
		$query = "UPDATE casos SET peso = peso+3 WHERE id=$id";
	}
	else{
		$query = "INSERT INTO casos(nivel3, nivel2, nivel1, proxima, peso) VALUES('$nivel3', '$nivel2', '$nivel1', '$proximo', 3)";				
	}
	
	$conexao->executa($query);
}




?>