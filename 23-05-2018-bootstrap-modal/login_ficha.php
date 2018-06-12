<form name="flogin" id="flogin" method="post" action="login_gravar.php">
	<div id="senhaincorreta"></div>
	<label for="login">Nome Completo:</label><br>
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		<input type="text" name="nome" id="nome" value="" class="form-control"  placeholder="Nome Completo" required>
	</div>
	<br>
	<label for="login">Login:</label><br>
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
		<input type="text" name="login" id="login" value="" class="form-control"  placeholder="Login de acesso" required>
	</div>
	<br>
	<label for="senha">Senha:</label><br>
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		<input type="password" name="senha" id="senha" value="" class="form-control"  placeholder="Senha de acesso" required>
	</div>
	<br>
	<label for="senha">Confirme a Senha:</label><br>
	<div class="input-group">
		<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		<input type="password" name="csenha" id="csenha" value="" class="form-control"  placeholder="Senha de acesso" required>
	</div>
	<br>
	<div class="modal-footer">
		<input type="submit" name="btlogin" id="btlogin" value=" Gravar " class="btn btn-success">
		<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	</div>
</form>