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
			die('N�o foi poss�vel realizar a conex�o com o Banco de Dados!!!');
		}		
	} // construct

} // class Bd

