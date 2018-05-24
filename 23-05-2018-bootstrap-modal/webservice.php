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

	// Descrição do Prato ----------------------------------------------------
	if( $_POST['tipo'] == 'composicao_descricao_do_prato')
	{
		
		$cod_prato = $_POST['cod_prato'];

		
		$sql = "	select descricao, valor_unitario
					from 	pratos
					where	cod_prato = '$cod_prato'		
				";

		$r = $pdo->query($sql);

		if( $dados = $r->fetch(PDO::FETCH_ASSOC) ) {

			echo '<strong>' . strtoupper($dados['descricao']) . '</strong> <br>';
			//echo 'Valor de Venda: R$ '.number_format($dados['valor_unitario'],2,',','.') .' <br>';
			echo '<small>Composição do Prato</small>';	
		}
		else {
			echo 'Composição do Prato';
		}

	} // if( $_POST['tipo'] == 'composicao_descricao_do_prato')	

	// Listagem da Composição ----------------------------------------------------
	if( $_POST['tipo'] == 'composicao_listar')
	{
		
		$cod_prato = $_POST['cod_prato'];

		include_once('composicao_form.php');
		
		$sql = "	select c.* , i.descricao as ingrediente, i.valor_unitario, p.valor_unitario as valor_venda
					from 	composicao c 
							inner join ingredientes i on (c.cod_ingrediente = i.cod_ingrediente)
							inner join pratos p on (p.cod_prato = c.cod_prato)
					where	c.cod_prato = '$cod_prato'		
					order by ingrediente
		";

		$r = $pdo->query($sql);

		if( $r->rowCount() == 0 )
		{
			echo 'Este prato ainda não possui composição!';
			exit;
		}

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Ingrediente</strong></td>';
		echo ' <td class="text-right"><strong>Quantidade</strong></td>';
		echo ' <td class="text-right"><strong>Valor Unitário</strong></td>';
		echo ' <td class="text-right"><strong>Valor de Custo</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		$vl_custo = 0;
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			$vl_venda = $dados['valor_venda'];
			echo '<tr class="active">';
			echo ' <td>'.$dados['ingrediente'].'</td>';
			echo ' <td class="text-right">'. number_format($dados['qde'],2,',','.') .'</td>';
			echo ' <td class="text-right">'. number_format($dados['valor_unitario'],2,',','.') .'</td>';
			echo ' <td class="text-right">'. number_format($dados['valor_unitario'] * $dados['qde'],2,',','.') .'</td>';
			echo ' <td class="text-center">';
			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir_ingrediente('.$dados['cod_prato'].','.$dados['cod_ingrediente'].');">Excluir</a>';
			echo ' </td>';
			echo '</tr>';

			$vl_custo += $dados['qde'] * $dados['valor_unitario'];
		}

		echo '<tr class="active">';
		echo ' <td colspan="3"><strong>Valor Total de Custo do Prato</strong></td>';
		echo ' <td colspan="1" class="text-right"><strong style="color:#f00;">R$ '.number_format($vl_custo,2,',','.') .'</strong></td>';
		echo ' <td colspan="1"></td>';
		echo '</tr>';

		echo '<tr class="active">';
		echo ' <td colspan="3"><strong>Valor de Venda</strong></td>';
		echo ' <td colspan="1" class="text-right"><strong style="color:#00f;">R$ '.number_format($vl_venda,2,',','.') .'</strong></td>';
		echo ' <td colspan="1"></td>';
		echo '</tr>';

		echo '<tr class="active">';
		

		if( $vl_venda - $vl_custo > 0) {
			echo ' <td colspan="3"><strong style="color:#00f;">LUCRO</strong></td>';
			echo ' <td colspan="1" class="text-right"><strong style="color:#00f;">R$ '.number_format($vl_venda - $vl_custo,2,',','.') .'</strong></td>';
		}
		else {
			echo ' <td colspan="3"><strong style="color:#f00;">PREJUÍZO</strong></td>';
			echo ' <td colspan="1" class="text-right"><strong style="color:#f00;">R$ '.number_format($vl_venda - $vl_custo,2,',','.') .'</strong></td>';	
		}

		echo ' <td colspan="1"></td>';
		echo '</tr>';

		echo "</table>";

	} // if( $_POST['tipo'] == 'composicao_listar')

	// Excluir Item da Composição ----------------------------------------------------
	if( $_POST['tipo'] == 'composicao_incluir')
	{
		$cod_prato       = $_POST['cod_prato'];		
		$cod_ingrediente = $_POST['cod_ingrediente'];
		$qde 			 = floatUSA($_POST['qde']);
		
		$sql = "	INSERT into composicao (cod_prato, cod_ingrediente, qde)
					VALUES ('$cod_prato', '$cod_ingrediente', '$qde')
				";

		$cmd = $pdo->prepare($sql);
		$r = $cmd->execute();



		if( !$r ){
			echo '<span style="color:#f00;">Não foi possível incluir este item !</span>';
		}
		else{
			echo '';
		}


	} // if( $_POST['tipo'] == 'composicao_incluir')


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
		$r = $cmd->execute();



		if( !$r ){
			echo '<span style="color:#f00;">Não foi possível excluir este item !</span>';
		}
		else{
			echo '';
		}


	} // if( $_POST['tipo'] == 'composicao_excluir')

