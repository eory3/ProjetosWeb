<?php 
session_start();

//importando o banco
require_once('conexao.php');

//fazendo busca no banco

$nTecnologia = $pdo->prepare("SELECT * FROM novaTecnologia");

$nTecnologia->execute();

?>
<!doctype html>
<html>
<head>
	<!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

	<meta charset="UTF-8">
	<title>Entrevistando</title>
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
		
		<!-- Formulario Basico -->
		<form method="post" action="valEntrevista.php">
			<div class="form-group">
				<label for="nome">Nome Completo:</label>
				<input type="text" class="form-control" id="nome" name="nomeEntrevista" required>
			</div>
			<div class="form-group">
				<label for="idade">Idade:</label>
				<input type="number" class="form-control" id="idade" name="idadeEntrevista" required>
			</div>
			
			<!-- radio -->
			<div class="form-group">
				<p>Sexo:</p>
				<div class="form-check-inline">
					<label class="form-check-label">
						<input type="radio" name="sexoEntrevista" class="form-check-input" value="masculino" checked>Masculino  
					</label>
					<label class="form-check-label">
						<input type="radio" name="sexoEntrevista" class="form-check-input" value="feminino">Feminino  
					</label>                                
				</div>
			</div>

			<!-- checkbox -->
			<div class="form-group">
				<p>Tecnologia de Conhecimento:</p>
				<div class="form-check-inline">
					<?php if($nTecnologia->rowCount()): 
                        while($row = $nTecnologia->fetch(PDO::FETCH_ASSOC)){?>
                        <label>
                            <input type="checkbox" class="form-check-input" name=tecnologiaEntrevista value="<?php echo $row['nome']; ?>">
                            <?php echo $row['nome']; ?>
                        </label>
                        <?php } ?>
                    <?php endif; ?>					                        
				</div>
			</div>

			<button type="submit" class="btn btn-primary">Concluir</button>
		</form>
	</div>
</body>
</html>
