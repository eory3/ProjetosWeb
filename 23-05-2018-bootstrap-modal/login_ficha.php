<?php 
	session_start();
 ?>
<div class="container">

	<div class="row">
		<div class="col-md-12">

			<div class="page-header text-center">
				<h3>NOVO USUARIO <small>FICHA</small></h3>
			</div>	


			<form name="flogin" id="flogin" method="post" action="autenticar.php">

				<?php
				if( @$_GET['loginerror'] != '')
				{
					echo '<div style="color:#f00;" class="text-center">'.$_GET['loginerror'].'</div>';
				}
				?>
				<label for="login">Nome do Usuário:</label><br>
				<div class="input-group">	
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" name="login" id="login" value="" class="form-control"  placeholder="Login de acesso" required>
				</div>
				<br>
				<label for="senha">Senhas:</label><br>
				<div class="input-group">	
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input type="password" name="senha" id="senha" value="" class="form-control"  placeholder="Login de acesso" required>
				</div>
				<br>
				<div class="form-group text-center">	
					<input type="submit" name="btlogin" id="btlogin" value=" Acessar " class="btn btn-success">
				</div>
			</form>

		</div>

	</div>

</div>	