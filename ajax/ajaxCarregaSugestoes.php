<meta charset="ISO-8859-1"><?php
require_once("../MySQL.class.php");

$tipo = $_POST['tipo'];

if($tipo = 1){
	$nivel1 = $_POST['nivel1'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT proxima FROM casos WHERE nivel3 is NULL AND nivel2 IS NULL AND nivel1=$nivel1 ORDER BY peso DESC LIMIT 3 ";
	$resultado = $conexao->consulta($queryVerificacao);
	$retorno = "";
	if(count($resultado)>0){ //existe?
		$retorno = $resultado[0]['proxima'].";".$resultado[1]['proxima'].";".$resultado[2]['proxima']);
	}	
	echo $retorno;
}
else if($tipo = 2){
	$nivel2 = $_POST['nivel2'];
	$nivel1 = $_POST['nivel1'];
	$proximo = $_POST['proximo'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT proxima FROM casos WHERE nivel3 is NULL AND nivel2=$nivel2 AND nivel1=$nivel1 ORDER BY peso DESC LIMIT 3 ";
	$resultado = $conexao->consulta($queryVerificacao);
	$retorno = "";
	if(count($resultado)>0){ //existe?
		$retorno = $resultado[0]['proxima'].";".$resultado[1]['proxima'].";".$resultado[2]['proxima']);
	}	
	echo $retorno;
}
else if($tipo = 3){
	$nivel3 = $_POST['nivel3'];
	$nivel2 = $_POST['nivel2'];
	$nivel1 = $_POST['nivel1'];
	$proximo = $_POST['proximo'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT proxima FROM casos WHERE nivel3=$nivel3 AND nivel2=$nivel2 AND nivel1=$nivel1 ORDER BY peso DESC LIMIT 3 ";
	$resultado = $conexao->consulta($queryVerificacao);
	$retorno = "";
	if(count($resultado)>0){ //existe?
		$retorno = $resultado[0]['proxima'].";".$resultado[1]['proxima'].";".$resultado[2]['proxima']);
	}	
	echo $retorno;
}




?>