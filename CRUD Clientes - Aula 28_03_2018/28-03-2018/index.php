<?php
    // instrui o php a não exibir avisos, apenas erros fatais no código
    //ini_set('error_reporting',0);

	// informando ao browser o conjunto de caracteres através do php
	header('Content-Type: text/html; charset=utf-8');

	// incluindo arquivos
	// include : se o arquivo apresentar erro, apenas um aviso será dado e o script continua
	// require : se o arquivo apresentar erro, é gerado um erro fatal e o script é interrompido
	// opção _once (include_once require_once) : garante que o arquivo será incluido apenas uma vez no script
	include_once('funcoes.php');
	include_once('bd.php');

	$pdo = new BD();// fazendo a conexão com o banco de dados
	$pdo = $pdo->conexao;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Gestão Comercial</title>

	<!-- incluindo a biblioteca jQuery -->
	<script type="text/javascript" src="_js/jquery-3.3.1.min.js"></script>

	<!-- incluindo a biblioteca de funções gerais -->
	<script type="text/javascript" src="_js/funcoes.js"></script>

</head>
<body>
	<h1>SISTEMA DE GESTÃO COMERCIAL</h1>
	<?php
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
	?>

</body>
</html>  