<?php
	// informando ao browser o conjunto de caracteres
	// através do php
	header('Content-Type: text/html; charset=utf-8');
	include_once('bd.php');
?>

<!DOCTYPE html>
<html>
<head>
	<!-- informando ao browser o conjunto de caracteres -->
	<!-- através do HTML 
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	-->
	<title>Cadastro de Cidades</title>
</head>
<body>
<h2>CADASTRO DE CIDADES</h2>

<?php
	// conexão com o banco de dados
	$pdo = new BD();
	$pdo = $pdo->conexao;
	
	if( !$c )
	{
		//echo 'Não foi possível fazer a conexão com o BD.';
		//exit; // interrompe o script
		die('Não foi possível fazer a conexão com o BD.');
	}

	// enviando um comando SQL para o banco de dados
	$r = $pdo->prepare('select * from cidades order by nome');
	$r->execute();

	// obtendo o próximo registro da consulta
	while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
	{
		echo 'Código da Cidade: ' . $dados['cod_cidade'];
		echo '<br>';
		echo 'Nome da Cidade: ' . $dados['nome'];
		echo '<br>';
		echo 'Unidade Federal: ' . $dados['uf'];
		echo '<p></p>';		
	} // while
?>
</body>
</html>
