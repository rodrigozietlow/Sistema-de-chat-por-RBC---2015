<?php
require_once($_SERVER['DOCUMENT_ROOT']."MySQL.class.php");
$idUsuario = $_POST['idLogado'];
$idOutro = $_POST['idConversa'];

$query = "SELECT * FROM conversa WHERE (idEnviador=$idUsuario OR idReceptor=$idUsuario) AND (idReceptor=$idOutro OR idEnviador=$idOutro) ORDER BY data ASC LIMIT 200";

$conexao = new MySQL();

$resultado = $conexao->consulta($query);

if(count($resultado)){
	foreach($resultado as $mensagem){
		if($mensagem['idReceptor']==$idOutro){// se o outro cara recebeu a msg, eu que enviei
			echo "<div class='conversa conversa-right'>".$mensagem['mensagem']."</div>";
			echo "<div class='clear-both'></div>
		}
	}
}

?>