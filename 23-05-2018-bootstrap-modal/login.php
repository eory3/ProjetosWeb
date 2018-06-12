</script>
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
				else if( @$_GET['loginsucesso'] != '')
				{
					echo '<div class="text-center">'.$_GET['loginsucesso'].'</div>';
				}
				?>
				<label for="login">Nome do Usuário:</label><br>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" name="login" id="login" value="" class="form-control"  placeholder="Login de acesso" required>
				</div>
				<label for="senha">Senha:</label><br>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input type="password" name="senha" id="senha" value="" class="form-control"  placeholder="Senha de acesso" required>
				</div>
				<br>
				<div class="form-group text-center">
					<input type="submit" name="btlogin" id="btlogin" value=" Acessar " class="btn btn-success">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalNovoLogin">Novo Acesso</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- NOVO LOGIN MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalNovoLogin">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="TitleNovoLogin">Novo Acesso</h4>
			</div>
			<div class="modal-body" id="BodyNovoLogin">
				<?php include_once('login_ficha.php'); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->