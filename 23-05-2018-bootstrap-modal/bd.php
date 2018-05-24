<?php

class BD
{
	public $conexao;

	function __construct()
	{
		try 
		{
			$this->conexao = new PDO("mysql:host=localhost;dbname=restaurante_tads","root","vertrigo");
		
		} catch(PDOException $e)
		{
			die('Não foi possível realizar a conexão com o Banco de Dados!!!');
		}		
	} // construct

} // class Bd

