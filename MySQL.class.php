<?php
include "BancoDeDados.class.php";
include "Configuracao.inc.php";

class MySQL extends BancoDeDados{
		
	public function __construct(){
		$this->conexao = mysql_connect(HOST, USUARIO, SENHA);
		mysql_select_db(BANCO,$this->conexao);		
	}
	
	public function __destruct(){
		mysql_close($this->conexao);
	}
	
	public function executa($sql){
		$retornoExecucao = mysql_query($sql,$this->conexao);
		return $retornoExecucao;
	}
	
	public function consulta($select){
		$query = mysql_query($select,$this->conexao);
		$retorno = array();
		$dados = array();
		while($retorno = mysql_fetch_array($query)){
			$dados[] = $retorno;
		}
		return $dados;
	}
}
?>