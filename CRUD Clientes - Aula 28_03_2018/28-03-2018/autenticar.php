<?php
	session_start();

	// se já estiver autenticado
	if( isset($_SESSION['usuario']) )
	{
		header('Location: index.php');
		exit;
	}


	$login = $_POST['login'];
	$senha = $_POST['senha'];

	if( $login == 'andre' && $senha == '123456' )
	{
		$_SESSION['usuario']['autenticado']= '1';
		$_SESSION['usuario']['login']= $login;
		$_SESSION['usuario']['nome_completo']= 'André Mendes';
		header('Location: index.php');
	}
	else
	{
		header('Location: index.php?loginerror=Usuario e/ou Senha Invalidos !');
	}





?>
