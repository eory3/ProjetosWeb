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
	<title>Gravando Fornecedor</title>
</head>
<body>

<?php
	echo 'Gravando os dados...';

	$acao = $_GET['acao'];

	if( $acao == 'alterar' or $acao == 'incluir')
	{

		$razao_social       = $_POST['razao_social']       == '' ? 'null' : "'$_POST[razao_social]'";
		$nome_fantasia   	= $_POST['nome_fantasia']      == '' ? 'null' : "'$_POST[nome_fantasia]'";
		$cnpj               = $_POST['cnpj']               == '' ? 'null' : "'$_POST[cnpj]'";
		$inscricao_estadual = $_POST['inscricao_estadual'] == '' ? 'null' : "'$_POST[inscricao_estadual]'";
		$endereco           = $_POST['endereco']           == '' ? 'null' : "'$_POST[endereco]'";
		$bairro             = $_POST['bairro']             == '' ? 'null' : "'$_POST[bairro]'";
		$cod_cidade         = $_POST['cod_cidade']         == '' ? 'null' : "'$_POST[cod_cidade]'";
		$cep                = $_POST['cep']                == '' ? 'null' : "'$_POST[cep]'";
		$telefone           = $_POST['telefone']           == '' ? 'null' : "'$_POST[telefone]'";
		$celular            = $_POST['celular']            == '' ? 'null' : "'$_POST[celular]'";
		$email              = $_POST['email']              == '' ? 'null' : "'$_POST[email]'";
	}

	if( $acao == 'excluir')
	{
		$cod_fornecedor = $_GET['cod_fornecedor'];
		$sql = " delete
		         from fornecedores
		         where cod_fornecedor = '$cod_fornecedor'
		       ";

	}
	else
	if( $acao == 'alterar')
	{
		$cod_fornecedor = $_GET['cod_fornecedor'];

		$sql = " update fornecedores set
										razao_social       = $razao_social,
										nome_fantasia      = $nome_fantasia,
										cnpj               = $cnpj,
										inscricao_estadual = $inscricao_estadual,
										endereco           = $endereco,
										bairro             = $bairro,
										cod_cidade         = $cod_cidade,
										cep                = $cep,
										telefone           = $telefone,
										celular            = $celular,
										email              = $email
		         where cod_fornecedor = '$cod_fornecedor'
		       ";
	}
	else
	if( $acao == 'incluir')
	{
		$sql = " insert into fornecedores (
										razao_social       ,
										nome_fantasia      ,
										cnpj               ,
										inscricao_estadual ,
										endereco           ,
										bairro             ,
										cod_cidade         ,
										cep                ,
										telefone           ,
										celular            ,
										email
									 )

				  values (
										$razao_social       ,
										$nome_fantasia      ,
										$cnpj               ,
										$inscricao_estadual ,
										$endereco           ,
										$bairro             ,
										$cod_cidade         ,
										$cep                ,
										$telefone           ,
										$celular            ,
										$email
				  	     )
		       ";

	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=fornecedores&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados
	$cmd = $pdo->prepare($sql);
	$r = $cmd->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=fornecedores&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=fornecedores&msg=Não foi possível efetuar a operação com o Banco de Dados !');
	}


?>


</body>
</html>