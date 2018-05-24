<?php
class ValidaEmail{
	public function setValidaEmail($email)
	{
		$ext = array('.com','.br','.net','.gov','.org','.tv');
		
		if(empty($email))
		{
			return 'Informe o e-mail';
		}
		else if(!preg_match('/^[0-9a-z\_\.\-]+\@[0-9a-z\_\.\-]*[0-9a-z\_\-]+\.[a-z]{2,3}$/i',$email))
		{
			return	'E-mail Invalido!';
		}
		else if (!in_array(strrchr($email,'.'),$ext))
		{
			return 'E-mail Invalido!';
		}
		else
		{
			return $email;
		}
	}	
}
?>