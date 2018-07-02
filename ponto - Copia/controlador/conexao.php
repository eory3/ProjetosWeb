<?php
	define('SERVER','localhost');
	define('BANCO','ponto');
	define('SENHA','vertrigo');
	define('USER','root');
	try{
		$pdo = new pdo('mysql:host='.SERVER.";dbname=".BANCO, USER, SENHA);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		echo "erro gerado $e";
	}

 ?>