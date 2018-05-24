<?php

//-------------------------------------------------------
function conectar_bd()
{

	try 
	{
		// conexão com o banco de dados
		$c = mysqli_connect('localhost','root','vertrigo');

		if( !$c)
		{
			throw new Exception('Não foi possível fazer a conexão com o BD.');
		}


		// selecionar a base de dados
		$base = mysqli_select_db($c, 'restaurante_tads');

		if( !$base )
		{
			throw new Exception('Não foi possível selecionar a base de dados.');
		}

		return $c;

	}
	catch (Exception $e)
	{
		die( $e->getMessage() );
	}

} // conectar_bd


?>