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
	<title>Gravando prato</title>
</head>
<body>

<?php
	echo 'Gravando os dados...';

	$acao = $_GET['acao'];

	if( $acao == 'alterar' or $acao == 'incluir')
	{
		$descricao = $_POST['descricao'];
		$cod_categoria = $_POST['cod_categoria'];
		$valor_unitario = floatUSA($_POST['valor_unitario']);

	}

	//echo $_POST['cod_categoria']; exit;

	if( $acao == 'excluir')
	{
		$cod_prato = $_GET['cod_prato'];
		$sql = " delete 
		         from pratos 
		         where cod_prato = :cod_prato
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_prato',$cod_prato);

	}
	else
	if( $acao == 'alterar')
	{
		$cod_prato = $_GET['cod_prato'];

		$sql = " update pratos set
					 descricao = :descricao,
					 cod_categoria = :cod_categoria,
					 valor_unitario = :valor_unitario
		         where cod_prato = :cod_prato
		       ";
		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_prato',$cod_prato);
		$cmd->bindValue(':descricao',$descricao);
		$cmd->bindValue(':cod_categoria',$cod_categoria);
		$cmd->bindValue(':valor_unitario',$valor_unitario);

	}
	else
	if( $acao == 'incluir')
	{

		$sql = " insert into pratos (descricao, cod_categoria, valor_unitario)
				  values (:descricao,:cod_categoria,:valor_unitario)
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':descricao',$descricao);
		$cmd->bindValue(':cod_categoria',$cod_categoria);
		$cmd->bindValue(':valor_unitario',$valor_unitario);
	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=pratos&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados	
	$r = $cmd->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=pratos&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=pratos&msg=Não foi possível efetuar a operação com o Banco de Dados !');	
	}		


?>


</body>
</html>