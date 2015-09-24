<?phpheader('Content-Type: text/html; charset=ISO-8859-1');
require_once("../MySQL.class.php");$_POST = array_map('strtolower', $_POST);

$tipo = $_POST['tipo'];

if($tipo == 1){
	$nivel1 = $_POST['nivel1'];	//echo $nivel1;
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT proxima, peso FROM casos WHERE nivel3 is NULL AND nivel2 IS NULL AND nivel1='$nivel1' ORDER BY peso DESC LIMIT 3 ";
	$resultado = $conexao->consulta($queryVerificacao);
	$retorno = "";
	if(count($resultado)>0){ //existe?		foreach($resultado as $coisa){
			$retorno .= $coisa['proxima'].":".$coisa['peso'].";";		}
	}	
	echo $retorno;
}
else if($tipo == 2){
	$nivel2 = $_POST['nivel2'];
	$nivel1 = $_POST['nivel1'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT proxima, peso FROM casos WHERE nivel3 is NULL AND nivel2='$nivel2' AND nivel1='$nivel1' ORDER BY peso DESC LIMIT 3 ";
	$resultado = $conexao->consulta($queryVerificacao);
	$retorno = "";
	if(count($resultado)>0){ //existe?
		foreach($resultado as $coisa){			$retorno .= $coisa['proxima'].":".$coisa['peso'].";";		}
	}	
	echo $retorno;
}
else if($tipo == 3){
	$nivel3 = $_POST['nivel3'];
	$nivel2 = $_POST['nivel2'];
	$nivel1 = $_POST['nivel1'];
	$conexao = new MySQL();
	
	$queryVerificacao = "SELECT proxima, peso FROM casos WHERE nivel3='$nivel3' AND nivel2='$nivel2' AND nivel1='$nivel1' ORDER BY peso DESC LIMIT 3 ";
	$resultado = $conexao->consulta($queryVerificacao);
	$retorno = "";
	if(count($resultado)>0){ //existe?
		foreach($resultado as $coisa){			$retorno .= $coisa['proxima'].":".$coisa['peso'].";";		}
	}	
	echo $retorno;
}




?>