<?php
ini_set('error_reporting',0);
header('Content-Type: text/html; charset=utf-8');

include_once("bd.php");
include_once('funcoes.php');

	// Fazendo a conexão com o Banco de Dados	
$pdo = new BD();	
$pdo = $pdo->conexao;

echo 'Gravando os dados...';

$nome =  $_POST['nome'];
$login = $_POST['login'];
$senha = md5($_POST['senha']);

$sql = " insert into usuarios (nome_completo, login, senha)
values (:nome,:login,:senha)
";

$cmd = $pdo->prepare($sql);
$cmd->bindValue(':nome',$nome);
$cmd->bindValue(':login',$login);
$cmd->bindValue(':senha',$senha);

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados	
$r = $cmd->execute();

if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?loginsucesso=Digite o novo login e senha para acessar !');
	}
	else
	{
		header('Location: index.php?loginerror=Não foi possivel criar um novo login provavelmente esse ja existe tente novamente com um login diferente !');
	}
?>