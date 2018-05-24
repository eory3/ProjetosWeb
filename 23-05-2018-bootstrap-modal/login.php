<div class="container">

	<div class="row">
		<div class="col-md-12">

	<div class="page-header text-center">
		<h3>ACESSO AO SISTEMA</h3>
	</div>	


				<form name="flogin" id="flogin" method="post" action="autenticar.php">

					<?php
						if( @$_GET['loginerror'] != '')
						{
							echo '<div style="color:#f00;" class="text-center">'.$_GET['loginerror'].'</div>';
						}
					?>
					
					<div class="form-group">	
						<label for="login">Nome do Usuário:</label><br>
						<input type="text" name="login" id="login" value="" class="form-control"  placeholder="Login de acesso">
					</div>

					<div class="form-group">	
						<label for="login">Senhas:</label><br>
						<input type="password" name="senha" id="senha" value="" class="form-control"  placeholder="Login de acesso">
					</div>


					<div class="form-group text-center">	
						<input type="submit" name="btlogin" id="btlogin" value=" Acessar " class="btn btn-success">
					</div>


			</form>

		</div>

	</div>

</div>	