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

		$nome   		         = $_POST['nome']            == '' ? 'null' : "'$_POST[nome]'";
		$cpf    		         = $_POST['cpf']  			 == '' ? 'null' : "'$_POST[cpf]'";
		$data_nascimento         = $_POST['data_nascimento'] == '' ? 'null' : "'" . dataUSA($_POST['data_nascimento']) . "'";
		$renda_familiar          = $_POST['renda_familiar']  == '' ? 'null' : "'" . floatUSA($_POST['renda_familiar']) . "'";
		$rg                      = $_POST['rg']  		     == '' ? 'null' : "'$_POST[rg]'";
		$telefone                = $_POST['telefone']  		 == '' ? 'null' : "'$_POST[telefone]'";
		$celular                 = $_POST['celular']  	     == '' ? 'null' : "'$_POST[celular]'";
		$email                   = $_POST['email']  	     == '' ? 'null' : "'$_POST[email]'";
		$rua                     = $_POST['rua']  			 == '' ? 'null' : "'$_POST[rua]'";
		$bairro                  = $_POST['bairro']  		 == '' ? 'null' : "'$_POST[bairro]'";
		$cod_cidade              = $_POST['cod_cidade']  	 == '' ? 'null' : "'$_POST[cod_cidade]'";
		$cep                     = $_POST['cep']  		     == '' ? 'null' : "'$_POST[cep]'";
		$conheceu_por_jornais    = @$_POST['conheceu_por_jornais']  == '' ? 'null' : "'$_POST[conheceu_por_jornais]'";
		$conheceu_por_internet   = @$_POST['conheceu_por_internet'] == '' ? 'null' : "'$_POST[conheceu_por_internet]'";
		$conheceu_por_outro      = @$_POST['conheceu_por_outro']  	== '' ? 'null' : "'$_POST[conheceu_por_outro]'";
		$sexo                    = @$_POST['sexo']  				== '' ? 'null' : "'$_POST[sexo]'";
	}

	if( $acao == 'excluir')
	{
		$cod_cliente = $_GET['cod_cliente'];
		$sql = " delete 
		         from clientes 
		         where cod_cliente = '$cod_cliente'
		       ";

	}
	else
	if( $acao == 'alterar')
	{
		$cod_cliente = $_GET['cod_cliente'];

		$sql = " update clientes set
										nome                  = $nome                  ,
										cpf                   = $cpf                   ,
										data_nascimento       = $data_nascimento       ,
										renda_familiar        = $renda_familiar        ,
										rg                    = $rg                    ,
										telefone              = $telefone              ,
										celular               = $celular               ,
										email                 = $email                 ,
										rua                   = $rua                   ,
										bairro                = $bairro                ,
										cod_cidade            = $cod_cidade            ,
										cep                   = $cep                   ,
										conheceu_por_jornais  = $conheceu_por_jornais  ,
										conheceu_por_internet = $conheceu_por_internet ,
										conheceu_por_outro    = $conheceu_por_outro    ,
										sexo                  = $sexo
		         where cod_cliente = '$cod_cliente'
		       ";
	}
	else
	if( $acao == 'incluir')
	{
		$sql = " insert into clientes (
										nome                  ,
										cpf                   ,
										data_nascimento       ,
										renda_familiar        ,
										rg                    ,
										telefone              ,
										celular               ,
										email                 ,
										rua                   ,
										bairro                ,
										cod_cidade            ,
										cep                   ,
										conheceu_por_jornais  ,
										conheceu_por_internet ,
										conheceu_por_outro    ,
										sexo                  
									 )

				  values (
										$nome                  ,
										$cpf                   ,
										$data_nascimento       ,
										$renda_familiar        ,
										$rg                    ,
										$telefone              ,
										$celular               ,
										$email                 ,
										$rua                   ,
										$bairro                ,
										$cod_cidade            ,
										$cep                   ,
										$conheceu_por_jornais  ,
										$conheceu_por_internet ,
										$conheceu_por_outro    ,
										$sexo
				  	     )
		       ";

	}
	else
	{
		// redirecionando
		header('Location: index.php?modulo=clientes&msg=Ação Inválida!');
	}

	//echo $sql; exit;

	// enviando o comando sql para o banco de dados
	$cmd = $pdo->prepare($sql);
	$r = $cmd->execute();

	if( $r ) // se houve sucesso
	{
		// redirecionando
		header('Location: index.php?modulo=clientes&msg=Ação concluida com Sucesso !');
	}
	else
	{
		header('Location: index.php?modulo=clientes&msg=Não foi possível efetuar a operação com o Banco de Dados !');	
	}		


?>


</body>
</html>