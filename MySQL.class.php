<?php
include "BancoDeDados.class.php";
include "Configuracao.inc.php";

class MySQL extends BancoDeDados{
		
	public function __construct(){
		$this->conexao = mysqli_connect(HOST, USUARIO, SENHA, BANCO );	
	}
	
	public function __destruct(){
		mysqli_close($this->conexao);
	}
	
	public function executa($sql){
		$retornoExecucao = mysqli_query($this->conexao, $sql);
		return $retornoExecucao;
	}
	
	public function consulta($select){
		//echo $select;
		$query = mysqli_query($this->conexao, $select);
		$retorno = array();
		$dados = array();
		while($retorno = mysqli_fetch_assoc($query)){
			$dados[] = $retorno;
		}
		return $dados;
	}
}
?>