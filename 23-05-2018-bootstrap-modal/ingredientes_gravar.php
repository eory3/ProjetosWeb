<?php
	session_start();

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

	if( $acao == 'alterar' or $acao == 'incluir')
	{

		$descricao   	= $_POST['descricao']       == '' ? 'null' : "'$_POST[descricao]'";
		$valor_unitario = $_POST['valor_unitario']  == '' ? 'null' : "'$_POST[valor_unitario]'";
		$cod_unidade    = $_POST['cod_unidade']     == '' ? 'null' : "'$_POST[cod_unidade]'";
	}

	if( $acao == 'excluir')
	{
		$cod_ingrediente = $_GET['cod_ingrediente'];
		$sql = " delete 
		         from ingredientes 
		         where cod_ingrediente = '$cod_ingrediente'
		       ";

	}
	else
	if( $acao == 'alterar')
	{
		$cod_ingrediente = $_GET['$cod_ingrediente'];

		$sql = " update ingredientes set
										descricao       = $descricao      ,
										valor_unitario  = $valor_unitario ,
										cod_unidade     = $cod_unidade
		         where cod_ingrediente = '$cod_ingrediente'
		       ";
	}
	else
	if( $acao == 'incluir')
	{
		$sql = " insert into ingredientes (
										descricao      ,
										valor_unitario ,
										cod_unidade
									 )

				  values (
										$descricao      ,
										$valor_unitario ,
										$cod_unidade
				  	     )
		       ";

	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=ingredientes&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados
	$cmd = $pdo->prepare($sql);
	$r = $cmd->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=ingredientes&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=ingredientes&msg=Não foi possível efetuar a operação com o Banco de Dados !');	
	}		


?>


</body>
</html>