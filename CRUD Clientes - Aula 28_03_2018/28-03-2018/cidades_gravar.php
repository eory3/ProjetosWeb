<?php

    ini_set('error_reporting',0);
	header('Content-Type: text/html; charset=utf-8');

	include_once('funcoes.php');
	include_once('bd.php');

	$pdo = new BD();
	$pdo = $pdo->conexao;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Gravando Cidade</title>
</head>
<body>

<?php
	echo 'Gravando os dados...';

	$acao = $_GET['acao'];

	if( $acao == 'excluir')
	{
		$cod_cidade = $_GET['cod_cidade'];
		$sql = " delete 
		         from cidades 
		         where cod_cidade = '$cod_cidade'
		       ";

	}
	else
	if( $acao == 'alterar')
	{
		$cod_cidade = $_GET['cod_cidade'];
		$nome = $_POST['nome'];
		$uf = $_POST['uf'];

		$sql = " update cidades set
					 nome = '$nome',
					 uf = '$uf'
		         where cod_cidade = '$cod_cidade'
		       ";
	}
	else
	if( $acao == 'incluir')
	{
		$nome = $_POST['nome'];
		$uf = $_POST['uf'];

		$sql = " insert into cidades (nome, uf)
				  values ('$nome','$uf')
		       ";

	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=cidades&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados
	$r = $pdo->prepare($sql);
	$r->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=cidades&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=cidades&msg=Não foi possível efetuar a operação com o Banco de Dados !');	
	}		


?>


</body>
</html>