<?php 
session_start();
?>
<!doctype html>
<html>
<head>
	<!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	
	<meta charset="UTF-8">	
	<title>Cadastrando Nova Tecnologia</title>
</head>
<body>

	<!-- menu -->
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
		<a class="navbar-brand" href="index.php">Home</a>
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="addNovaTecnologia.php">Cadastrar nova tecnologia</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="addEntrevista.php">Entrevistar</a>
			</li>
		</ul>
	</nav>

	<!-- div principal -->
	<div class="container" style="margin-top: 80px;">
		
		<!-- formularo -->
		<form method="post" action="valNovaTecnologia.php">
			<div class="form-group">
				<label for="tecnologia">Nome da Tecnologia:</label>
				<input type="text" class="form-control" id="tecnologia" name="nome" required>
			</div>
			<div class="form-group">
				<label for="vagas">Numero de Vagas:</label>
				<input type="number" class="form-control" id="vagas" name="vaga" required>
			</div>
			<button type="submit" class="btn btn-primary">Cadastrar</button>
		</form>
	</div>
</body>
</html>

