<?php
	session_start();
	
	// se NÃO estiver autenticado
	if( !isset($_SESSION['usuario']) )
	{
		die('Usuário não autenticado!!!');
	}

    ini_set('error_reporting',0);
	header('Content-Type: text/html; charset=utf-8');

	include_once("bd.php");
	include_once('funcoes.php');

	// Fazendo a conexão com o Banco de Dados	
	$pdo = new BD();	
	$pdo = $pdo->conexao;

	// Listagem da Composição ----------------------------------------------------
	if( $_POST['tipo'] == 'composicao_listar')
	{
		
		$cod_prato = $_POST['cod_prato'];

		$sql = "	select c.* , i.descricao as ingrediente
					from 	composicao c 
							inner join ingredientes i on (c.cod_ingrediente = i.cod_ingrediente)
					where	c.cod_prato = '$cod_prato'		
					order by ingrediente
		";

		$r = $pdo->query($sql);

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Ingrediente</strong></td>';
		echo ' <td ><strong>Quantidade</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			echo '<tr class="active">';
			echo ' <td>'.$dados['ingrediente'].'</td>';
			echo ' <td>'. number_format($dados['qde'],2,',','.') .'</td>';
			echo ' <td class="text-center">';
			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir_ingrediente('.$dados['cod_prato'].','.$dados['cod_ingrediente'].');">Excluir</a>';
			echo ' </td>';
			echo '</tr>';
		}


		echo "</table>";

	} // if( $_POST['tipo'] == 'composicao_listar')


	// Excluir Item da Composição ----------------------------------------------------
	if( $_POST['tipo'] == 'composicao_excluir')
	{
		$cod_prato = $_POST['cod_prato'];
		$cod_ingrediente = $_POST['cod_ingrediente'];

		$sql = "	DELETE from composicao 							
					where	cod_prato = '$cod_prato' and 	
							cod_ingrediente = '$cod_ingrediente'  
				";

		$cmd = $pdo->prepare($sql);
		$cmd->execute();

	}

