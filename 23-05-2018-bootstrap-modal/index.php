<?php
	session_start();
    // instrui o php a não exibir avisos, apenas erros fatais no código
    //ini_set('error_reporting',0);

	// informando ao browser o conjunto de caracteres através do php
	header('Content-Type: text/html; charset=utf-8');

	// incluindo arquivos
	// include : se o arquivo apresentar erro, apenas um aviso será dado e o script continua
	// require : se o arquivo apresentar erro, é gerado um erro fatal e o script é interrompido
	// opção _once (include_once require_once) : garante que o arquivo será incluido apenas uma vez no script
	include_once("bd.php");
	include_once('funcoes.php');

	// Fazendo a conexão com o Banco de Dados	
	$pdo = new BD();	
	$pdo = $pdo->conexao;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Gestão Comercial</title>

	<!-- INSERINDO O BOOTSTRAP -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- incluindo css-->	
    <link href="_bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- incluindo a biblioteca jQuery -->
	<script type="text/javascript" src="_js/jquery-3.3.1.min.js"></script>
	
	<!-- incluindo a biblioteca de funções gerais -->
	<script type="text/javascript" src="_js/funcoes.js"></script>

	<!-- incluindo a biblioteca do Bootstrap -->
	<script src="_bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
	<div class="container-fluid">
	
		<div class="row" style="background-color: #222;">
			<div class="col-md-12">
				<h1 style="color:#fff;">SISTEMA DE GESTÃO COMERCIAL</h1>
			</div>
		</div>

		<?php

			// verificando se o usário está autenticado
			if( isset($_SESSION['usuario']) )
			{
				include_once('menuprincipal.php');

				$arquivo = @$_GET['modulo'] . '.php';

				if( file_exists($arquivo) )	
				{
					include_once($arquivo);
				}
				else
				{
					include_once('home.php');
				}
			}
			else 
			{
				include_once('login.php');
			}
		?>

	</div>
</body>
</html>  