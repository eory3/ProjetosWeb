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
	<title>Gravando Unidade</title>
</head>
<body>

<?php
	echo 'Gravando os dados...';

	$acao = $_GET['acao'];

	if( $acao == 'excluir')
	{
		$cod_unidade = $_GET['cod_unidade'];
		$sql = " delete 
		         from unidades 
		         where cod_unidade = :cod_unidade
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_unidade',$cod_unidade);

	}
	else
	if( $acao == 'alterar')
	{
		$cod_unidade = $_GET['cod_unidade'];
		$descricao = $_POST['descricao'];

		$sql = " update unidades set
					 descricao = :descricao
		         where cod_unidade = :cod_unidade
		       ";
		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_unidade',$cod_unidade);
		$cmd->bindValue(':descricao',$descricao);

	}
	else
	if( $acao == 'incluir')
	{
		$descricao = $_POST['descricao'];

		$sql = " insert into unidades (descricao)
				  values (:descricao)
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':descricao',$descricao);
	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=unidades&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados	
	$r = $cmd->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=unidades&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=unidades&msg=Não foi possível efetuar a operação com o Banco de Dados !');	
	}		


?>


</body>
</html>