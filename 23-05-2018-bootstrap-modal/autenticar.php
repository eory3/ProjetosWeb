<?php
	session_start();

	// se já estiver autenticado
	if( isset($_SESSION['usuario']) )
	{
		header('Location: index.php');
		exit;
	}

	include_once("bd.php");

	// Fazendo a conexão com o Banco de Dados	
	$pdo = new BD();	
	$pdo = $pdo->conexao;


	// sql injection - conteúdo do login: ' or 1=1 -- 
	// verifica se a propriedade (magic_quotes_gpc = Off) do php.ini está off
	if( get_magic_quotes_gpc() == '0' ) 
    {
       $_POST['login'] = addslashes($_POST['login']); // adiciona /' nas aspas
       $_POST['senha'] = addslashes($_POST['senha']);
    }	


	$login = $_POST['login'];
	$senha = md5($_POST['senha']);

	$sql = "select * from usuarios where login = '$login' and senha = '$senha'";

	//echo $sql; 

	$r = $pdo->query($sql);		

	if( $d = $r->fetch(PDO::FETCH_ASSOC) )
	{
		$_SESSION['usuario']['autenticado']= '1';
		$_SESSION['usuario']['login']= $login;
		$_SESSION['usuario']['nome_completo']= $d['nome_completo'];
		header('Location: index.php');
	}
	else
	{
		header('Location: index.php?loginerror=Usuario e/ou Senha Invalidos !');
	}





?>
