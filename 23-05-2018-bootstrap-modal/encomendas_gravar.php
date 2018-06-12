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
	<title>Gravando encomenda</title>
</head>
<body>

<?php
	echo 'Gravando os dados...';

	$acao = $_GET['acao'];

	if( $acao == 'alterar' or $acao == 'incluir')
	{
		$cod_cliente    = $_POST['cod_cliente'];
		$data           = dataUSA($_POST['data']);
	}

	if( $acao == 'excluir')
	{
		$num_encomenda = $_GET['num_encomenda'];
		$sql = " delete 
		         from encomendas 
		         where num_encomenda = :num_encomenda
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':num_encomenda',$num_encomenda);
	}
	else
	if( $acao == 'alterar')
	{
		$num_encomenda = $_GET['num_encomenda'];

		$sql = " update encomendas set
					 cod_cliente    = :cod_cliente,
					 data           = :data
		         where num_encomenda   = :num_encomenda
		       ";
		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':num_encomenda',$num_encomenda);
		$cmd->bindValue(':cod_cliente',$cod_cliente);
		$cmd->bindValue(':data',$data);

	}
	else
	if( $acao == 'incluir')
	{

		$sql = " insert into encomendas (cod_cliente, data)
				  values (:cod_cliente,:data)
		       ";

		$cmd = $pdo->prepare($sql);
		$cmd->bindValue(':cod_cliente',$cod_cliente);
		$cmd->bindValue(':data',$data);
	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=encomendas&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados	
	$r = $cmd->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=encomendas&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=encomendas&msg=Não foi possível efetuar a operação com o Banco de Dados !');	
	}		


?>


</body>
</html>