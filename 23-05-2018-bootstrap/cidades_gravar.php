<?php
	session_start();
	
	// se NÃO estiver autenticado
	if( !isset($_SESSION['usuario']) )
	{
		die('Usuário não autenticado!!!');
	}

    ini_set('error_reporting',0);
	header('Content-Type: text/html; charset=utf-8');

	include_once("bd.php");
	include_once('funcoes.php');

	// Fazendo a conexão com o Banco de Dados	
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
		         where cod_cidade = :cod_cidade
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_cidade',$cod_cidade);

	}
	else
	if( $acao == 'alterar')
	{
		$cod_cidade = $_GET['cod_cidade'];
		$nome = $_POST['nome'];
		$uf = $_POST['uf'];

		$sql = " update cidades set
					 nome = :nome,
					 uf = :uf
		         where cod_cidade = :cod_cidade
		       ";
		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_cidade',$cod_cidade);
		$cmd->bindValue(':nome',$nome);
		$cmd->bindValue(':uf',$uf);

	}
	else
	if( $acao == 'incluir')
	{
		$nome = $_POST['nome'];
		$uf = $_POST['uf'];

		$sql = " insert into cidades (nome, uf)
				  values (:nome,:uf)
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':nome',$nome);
		$cmd->bindValue(':uf',$uf);
	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=cidades&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados	
	$r = $cmd->execute();

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