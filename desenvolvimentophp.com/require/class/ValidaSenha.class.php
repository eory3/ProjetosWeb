<?php
class ValidaSenha
{
	public function setValidaSenha($pass)
	{
		if(strlen($pass)<1)
		{
			return 'Informe a senha';
		}
		else if(!preg_match('/^[0-9a-z]{8,12}$/i',$pass))
		{
			return 'Senha Invalida!';
		}
		else
		{
			return $pass;
		}
	}
}
?>