<?php
	// informando ao browser o conjunto de caracteres
	// através do php
	header('Content-Type: text/html; charset=utf-8');
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
	$c = mysqli_connect('localhost','root','vertrigo');

	if( !$c )
	{
		//echo 'Não foi possível fazer a conexão com o BD.';
		//exit; // interrompe o script
		die('Não foi possível fazer a conexão com o BD.');
	}

	// selecionar a base de dados
	$base = mysqli_select_db($c, 'tads2018');

	if( !$base ) die('Não foi possível selecionar a base de dados!');

	// enviando um comando SQL para o banco de dados
	$r=mysqli_query($c, 'select * from cidades order by nome');

	if( !$r ) die('Seu SQL está zuado, estude mais !');

	// verificando o número de registros da consulta
	//$linhas = mysql_num_rows($r);
	//echo "O total de linhas da consulta é $linhas<br>";
	echo '<p></p>';

	// obtendo o próximo registro da consulta
	while( $dados = mysqli_fetch_assoc($r) )
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
