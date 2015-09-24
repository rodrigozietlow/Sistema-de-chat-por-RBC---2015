<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once($_SERVER['DOCUMENT_ROOT']."/Sistema-de-chat-por-RBC---2015/MySQL.class.php");
$idUsuario = $_POST['idUsuario'];
$idOutro = $_POST['idOutro'];

$query = "SELECT * FROM conversa WHERE (idEnviador=$idUsuario OR idReceptor=$idUsuario) AND (idReceptor=$idOutro OR idEnviador=$idOutro) ORDER BY data ASC LIMIT 200";

$conexao = new MySQL();

$resultado = $conexao->consulta($query);

if(count($resultado)>0){
	foreach($resultado as $mensagem){
		if($mensagem['idReceptor']==$idOutro){// se o outro cara recebeu a msg, eu que enviei
			
			echo "<div class='conversa conversa-right hvr-bubble-float-right'>".utf8_decode($mensagem['mensagem'])."</div>";
			echo "<div class='clear-both'></div>";
		}else{
			echo "<div class='conversa conversa-left hvr-bubble-float-left'>".utf8_decode($mensagem['mensagem'])."</div>";
			echo "<div class='clear-both'></div>";
		}
	}
	echo "<input type='hidden' id='numeroMsgs' value=".count($resultado).">";
}

?>