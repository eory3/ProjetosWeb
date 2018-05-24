<?php 
session_start();
require_once('controlador/conexao.php');

$ponto = $pdo->prepare("SELECT * FROM horas");

$ponto->execute();

$total = 0;
$id = 0;

?>
<!doctype html>
<html>
<head>
	<title>
		PONTO
	</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="visualizacao/css/bootstrap.min.css">
	<link rel="stylesheet" href="visualizacao/css/datatables.min.css">
	<script type="text/javascript" charset="utf8" src="visualizacao/js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf8" src="visualizacao/js/jquery-3.3.1.slim.min.js"></script>
	<script type="text/javascript" charset="utf8" src="visualizacao/js/datatables.min.js"></script>
	<script type="text/javascript" charset="utf8" src="visualizacao/js/popper.min.js"></script>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<script>
		$(document).ready(function(){
			$('#tabela').DataTable();
		});
	</script>  	
</head>
<body class="bg-dark">
	
	<!-- div principal-->
	<div class="container">
		<!-- Image and text -->
		<nav class="site-header sticky-top py-1 bg-dark" style="border-radius: 5px; margin-top: 5px; opacity: 0.9;">
			<div class="container d-flex flex-column flex-md-row justify-content-between">
				<a class="navbar-brand" href="#" style="color: white;">
					<img src="imagens/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					EORY&copy; Home
				</a>
			</div>
		</nav>

		<div id="accordion" style="margin-top: 10px;">

			<!-- Tabela de tecnologias disponiveis e a quantidade de vagas -->
			<div class="card">
				<div class="bg-dark" style="border-radius: 2px;">
					<a class="card-link" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#tecnologiasCadastradas">
						PONTOS CADASTRADOS
					</a>
				</div>
				<div id="tecnologiasCadastradas" class="collapse show">
					<div class="card-body">                     
						<table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>DATA</th>
									<th>SEMANA</th>
									<th>TEMPO TRABALHADO</th>
									<th>VALOR</th>
									<th>AÇÃO</th>
								</tr>
							</thead>
							<tbody>

								<!-- atribuindo valores do banco na tabela -->
								<?php if($ponto->rowCount()): 
								while($row = $ponto->fetch(PDO::FETCH_ASSOC)){?>
								<?php 
								if($row['valor'] === '50'){
									$total += 50.0;
								}else{
									$total += 25.0;
								} ?>
								<tr>
									<td><?php echo $row['id']; ?></td>
								<td><?php 
										$data = date_create($row['data']); 
										echo date_format($data,'d/m/Y') ?></td>
								<td><?php 
								$semana = array('Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado');
								$data = $row['data'];
								$semanaNumero = date('w',strtotime($data));
								echo $semana[$semanaNumero].' - Feira';
								?></td>
								<td><?php echo $row['tempo']; ?></td>
								<td><?php echo $row['valor']."R$"; ?></td>
								<td>
									<!-- botoes -->
									<form method="POST" action="controlador/delPonto.php">
										<button type="submit" style="color: white;" class="form-control bg-dark" name="id" value="<?php echo $row['id']; ?>">
											Deletar
										</button>											
									</form>									  

									<!-- Button trigger modal -->
									<button type="button" style="color: white;" class="form-control bg-dark" data-toggle="modal" data-target="#exampleModal">
										Editar
									</button>

									<!-- Modal -->
									<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Editar Ponto</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="container">

														<form method="post" action="controlador/upPonto.php">
															<div class="form-group">
																<label for="data">Data:</label>
																<input type="date" class="form-control" id="data" name="dataPonto" required>
															</div>
															<div class="form-group">
																<label for="tempo">Tempo:</label>
																<select class="form-control" name="tempoPonto" id="tempo">
																	<option value=""></option>
																	<option value="Um Dia">Um Dia</option>
																	<option value="Meio Dia">Meio Dia</option>
																</select>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-dark" data-dismiss="modal">Cancelar</button>
																<button type="submit" name="id" value="<?php echo $row['id']; ?>" class="btn btn-dark">Alterar</button>
															</div>																
														</form>
													</div>                
												</div>

											</div>
										</div>
									</div>										

								</td>
							</tr>
							<?php } ?>
						<?php endif; ?>
					</tbody>
					<tfoot>						
						<tr>
							<th colspan="6"><?php echo "TOTAL: $total R$"; ?></th>
						</tr>
					</tfoot>
				</table>
				<!-- Button trigger modal -->
				<button type="button" style="color: white;" class="form-control bg-dark" data-toggle="modal" data-target="#exampleModal1">
					Adicionar Ponto
				</button>

				<!-- Modal -->
				<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel1">Adicionar Ponto</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="container">

									<form method="post" action="controlador/valPonto.php">
										<div class="form-group">
											<label for="data">Data:</label>
											<input type="date" class="form-control" placeholder="" id="data" name="dataPonto" required>
										</div>
										<div class="form-group">
											<label for="tempo">Tempo:</label>
											<select class="form-control" name="tempoPonto" id="tempo">
												<option value=""></option>
												<option value="Um Dia" selected>Um Dia</option>
												<option value="Meio Dia">Meio Dia</option>
											</select>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-dark" data-dismiss="modal">Cancelar</button>
											<button type="submit" class="btn btn-dark">Adicionar</button>
										</div>											
									</form>
								</div>                
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>        
</body>
</html>
