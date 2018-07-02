<?php
	session_start();

	include_once("bd.php");
	include_once('funcoes.php');

	// Fazendo a conexão com o Banco de Dados
	$pdo = new BD();
	$pdo = $pdo->conexao;


	// se já estiver autenticado
	if( isset($_SESSION['usuario']) )
	{
		header('Location: index.php');
		exit;
	}


	$login = $_POST['login'];
	$senha = $_POST['senha'];

	$sql = $pdo->query('select * from usuario where login = $login and senha = $senha');

	if( isset($sql) )
	{
		$_SESSION['usuario']['autenticado']= '1';
		$_SESSION['usuario']['login']= $login;
		$_SESSION['usuario']['nome_completo']= $r['nome_completo'];
		header('Location: index.php');
	}
	else
	{
		header('Location: index.php?loginerror=Usuario e/ou Senha Invalidos !');
	}
?>
