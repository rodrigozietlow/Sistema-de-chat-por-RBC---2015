<?php
session_start();
require_once("../MySQL.class.php");
$conexao = new MySQL();
$contadorFotos = 1;
$pessoas = "";
$retorno = "";
$queryConv = "SELECT DISTINCT nome, u.id FROM conversa c, usuarios u WHERE (u.id=c.idReceptor OR u.id=c.idEnviador) AND u.id<>".$_SESSION['id']." ORDER BY data DESC LIMIT 18";
$resultado = $conexao->consulta($queryConv);
if(count($resultado)>0){
	foreach($resultado as $cara){
		$contadorFotos++;
		$pessoas .= $cara['id'].",";
		$id = $cara['id'];
		$retorno.= "< class='img hvr-buzz-out' data-toggle='tooltip' title='' data-placement='bottom' data-original-title='".$cara['nome']."' data-id=$id src='https://github.com/identicons/".$cara['nome'].".png'>";
	}
}
if(strlen($pessoas)>0){
	$pessoas = substr($pessoas, 0, -1);
}else{
	$pessoas = "''";
}
if($contadorFotos<=18){
	$queryUsu = "SELECT nome, id FROM usuarios WHERE id NOT IN($pessoas) ORDER BY id DESC LIMIT 18";
	$resultado = $conexao->consulta($queryUsu);
	if(count($resultado)>0){
		foreach($resultado as $cara){
			$id = $cara['id'];
			if($id!=$_SESSION['id']){//nÃ£o Ã© eu mesmo!
				$contadorFotos++;
				$retorno.= "< class='img hvr-buzz-out' data-toggle='tooltip' title='' data-placement='bottom' data-original-title='".$cara['nome']."' data-id=$id src='https://github.com/identicons/".$cara['nome'].".png'>";
			}
		}
	}
}
echo $retorno;
?>	