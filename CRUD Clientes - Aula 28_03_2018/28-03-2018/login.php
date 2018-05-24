<h3>ACESSO AO SISTEMA</h3>

<form name="flogin" id="flogin" method="post" action="autenticar.php">

Nome do Usuário:</br>
<input type="text" name="login" id="login" value="">
<p></p>

Senha:</br>
<input type="password" name="senha" id="senha" value="">
<p></p>

<input type="submit" name="btlogin" id="btlogin" value=" Acessar ">

<?php
	if( @$_GET['loginerror'] != '')
	{
		echo '<div style="color:#f00;">'.$_GET['loginerror'].'</div>';
	}
?>

</form>