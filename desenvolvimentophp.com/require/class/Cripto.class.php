<?php
class Cripto
{
	public function setCripto($param)
	{
		/*$_cripto=md5($param);//32 caracteres
		$_cripto=sha1($param);//40 caracteres
		$_cripto=hash('sha256',$param);//64 caracteres
		$_cripto=hash('sha384',$param);//96 caracteres
		$_cripto=hash('sha512',$param);//128 caracteres
		$_cripto=hash('whirlpool',$param);//128 caracteres*/
		
		return hash('whirlpool',hash('sha512',hash('sha384',hash('sha256',sha1(md5($param))))));	
	}
}
?>