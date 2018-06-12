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
	<title>Gravando compra</title>
</head>
<body>

<?php
	echo 'Gravando os dados...';

	$acao = $_GET['acao'];

	if( $acao == 'alterar' or $acao == 'incluir')
	{
		$nota_fiscal    = $_POST['nota_fiscal'];
		$data           = dataUSA($_POST['data']);
		$cod_fornecedor = $_POST['cod_fornecedor'];
		$nota_serie     = $_POST['nota_serie'];

	}

	if( $acao == 'excluir')
	{
		$cod_compra = $_GET['cod_compra'];
		$sql = " delete 
		         from compras 
		         where cod_compra = :cod_compra
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_compra',$cod_compra);

	}
	else
	if( $acao == 'alterar')
	{
		$cod_compra = $_GET['cod_compra'];

		$sql = " update compras set
					 nota_fiscal    = :nota_fiscal,
					 data           = :data,
					 cod_fornecedor = :cod_fornecedor,
					 nota_serie     = :nota_serie
		         where cod_compra   = :cod_compra
		       ";
		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_compra',$cod_compra);
		$cmd->bindValue(':nota_fiscal',$nota_fiscal);
		$cmd->bindValue(':data',$data);
		$cmd->bindValue(':cod_fornecedor',$cod_fornecedor);
		$cmd->bindValue(':nota_serie',$nota_serie);

	}
	else
	if( $acao == 'incluir')
	{

		$sql = " insert into compras (nota_fiscal, data, cod_fornecedor, nota_serie)
				  values (:nota_fiscal,:data,:cod_fornecedor,:nota_serie)
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':nota_fiscal',$nota_fiscal);
		$cmd->bindValue(':data',$data);
		$cmd->bindValue(':cod_fornecedor',$cod_fornecedor);
		$cmd->bindValue(':nota_serie',$nota_serie);
	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=compras&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados	
	$r = $cmd->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=compras&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=compras&msg=Não foi possível efetuar a operação com o Banco de Dados !');	
	}		


?>


</body>
</html>