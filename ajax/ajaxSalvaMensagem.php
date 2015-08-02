<?php
require_once("../MySQL.class.php");
$mensagem = utf8_decode($_POST['mensagem']);

$idUsuario = $_POST['idUsuario'];

$idOutro = $_POST['idOutro'];
$conexao = new MySQL();
$query = "INSERT INTO conversa(idEnviador, idReceptor, mensagem, data) VALUES($idUsuario, $idOutro, '$mensagem','".date("Y-m-d H:i:s")."' )";

$conexao->executa($query);
$id = mysql_insert_id();

$query2 = "SELECT * FROM conversa WHERE id=$id";
$resultado = $conexao->consulta($query2);
if(count($resultado)>0){
	$resultado = $resultado[0];
	echo "<div class='conversa conversa-right hvr-bubble-float-right'>".utf8_encode($resultado['mensagem'])."</div>";
	echo "<div class='clear-both'></div>";
}
?>