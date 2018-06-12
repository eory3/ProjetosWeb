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

//---------------------------------------Composicao--------------------------------------------------------------//
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

	// Incluir Item da Composição ----------------------------------------------------
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

//---------------------------------------Fim Composicao-----------------------------------------------------------//

//---------------------------------------Itens Compra-------------------------------------------------------------//

// Descrição da Compra ----------------------------------------------------
	if( $_POST['tipo'] == 'itens_compra_descricao_da_compra')
	{
		
		$cod_compra = $_POST['cod_compra'];

		
		$sql = "	select nota_fiscal
					from 	compras
					where	cod_compra = $cod_compra		
				";

		$r = $pdo->query($sql);

		if( $dados = $r->fetch(PDO::FETCH_ASSOC) ) {

			echo 'Nota Fiscal ' .'<strong>' . strtoupper($dados['nota_fiscal']) . '</strong> <br>';
			//echo 'Valor de Venda: R$ '.number_format($dados['valor_unitario'],2,',','.') .' <br>';
			echo '<small>Itens Compra</small>';	
		}
		else {
			echo 'Itens Compra';
		}

	} // if( $_POST['tipo'] == 'composicao_descricao_do_prato')	

	// Listagem da Compra ----------------------------------------------------
	if( $_POST['tipo'] == 'itens_compra_listar')
	{
		
		$cod_compra = $_POST['cod_compra'];

		include_once('itens_compra_form.php');
		
		$sql = "	select ic.* , i.descricao as ingrediente, i.valor_unitario
					from 	itens_compra ic 
							inner join ingredientes i on (ic.cod_ingrediente = i.cod_ingrediente)
							inner join compras c on (c.cod_compra = ic.cod_compra)
					where	c.cod_compra = '$cod_compra'		
					order by ingrediente
		";

		$r = $pdo->query($sql);

		if( $r->rowCount() == 0 )
		{
			echo 'Está compra ainda não possui itens!';
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
			echo '<tr class="active">';
			echo ' <td>'.$dados['ingrediente'].'</td>';
			echo ' <td class="text-right">'. number_format($dados['qde'],2,',','.') .'</td>';
			echo ' <td class="text-right">'. number_format($dados['valor_unitario'],2,',','.') .'</td>';
			echo ' <td class="text-right">'. number_format($dados['valor_unitario'] * $dados['qde'],2,',','.') .'</td>';
			echo ' <td class="text-center">';
			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir_itens_compra('.$dados['cod_compra'].','.$dados['cod_ingrediente'].');">Excluir</a>';
			echo ' </td>';
			echo '</tr>';

			$vl_custo += $dados['qde'] * $dados['valor_unitario'];
		}

		echo '<tr class="active">';
		echo ' <td colspan="3"><strong>Valor Total de Custo da Compra</strong></td>';
		echo ' <td colspan="1" class="text-right"><strong style="color:#f00;">R$ '.number_format($vl_custo,2,',','.') .'</strong></td>';
		echo ' <td colspan="1"></td>';
		echo '</tr>';

		echo ' <td colspan="1"></td>';
		echo '</tr>';

		echo "</table>";

	} // if( $_POST['tipo'] == 'itens_compra_listar')

	// Incluir Item da Compra ----------------------------------------------------
	if( $_POST['tipo'] == 'intens_compra_incluir')
	{
		$cod_compra       = $_POST['cod_compra'];		
		$cod_ingrediente  = $_POST['cod_ingrediente'];
		$qde 			  = floatUSA($_POST['qde']);
		$valor_total 	  = floatUSA($_POST['valor_total']);
		
		$sql = "	INSERT into itens_compra (cod_compra, cod_ingrediente, qde, valor_unitario)
					VALUES ('$cod_compra', '$cod_ingrediente', '$qde' , 
					(select valor_unitario from ingredientes where cod_ingrediente = $cod_ingrediente)
					)
				";

		$cmd = $pdo->prepare($sql);
		$r = $cmd->execute();

		

		$sql1 = "	UPDATE compras 
						SET valor_total = 
							(	SELECT sum(itens_compra.qde * itens_compra.valor_unitario) 
							 	FROM itens_compra 
							 	WHERE cod_compra = $cod_compra
							) 
					WHERE cod_compra = $cod_compra
				";

		$cmd1 =  $pdo->prepare($sql1);
		$r1 = $cmd1->execute();

		if( !$r ){
			echo '<span style="color:#f00;">Não foi possível incluir este item !</span>';
		}
		else{
			echo '';
		}


	} // if( $_POST['tipo'] == 'itens_compra_incluir')


	// Excluir Item da Compra ----------------------------------------------------
	if( $_POST['tipo'] == 'itens_compra_excluir')
	{
		
		$cod_compra = $_POST['cod_compra'];
		$cod_ingrediente = $_POST['cod_ingrediente'];

		$sql = "	DELETE from itens_compra 							
					where	cod_compra = '$cod_compra' and 	
							cod_ingrediente = '$cod_ingrediente'  
				";

		$cmd = $pdo->prepare($sql);
		$r = $cmd->execute();

		$sql1 = "	UPDATE compras 
						SET valor_total = 
							(	SELECT sum(itens_compra.qde * itens_compra.valor_unitario) 
							 	FROM itens_compra 
							 	WHERE cod_compra = $cod_compra
							) 
					WHERE cod_compra = $cod_compra
				";

		$cmd1 =  $pdo->prepare($sql1);
		$r1 = $cmd1->execute();

		if( !$r ){
			echo '<span style="color:#f00;">Não foi possível excluir este item !</span>';
		}
		else{
			echo '';
		}


	} // if( $_POST['tipo'] == 'itens_compra_excluir')

//---------------------------------------Fim Itens Compra---------------------------------------------------------//

//---------------------------------------Itens Encomenda----------------------------------------------------------//

// Descrição da Compra ----------------------------------------------------
	if( $_POST['tipo'] == 'itens_encomenda_descricao_da_encomenda')
	{
		
		$num_encomenda = $_POST['num_encomenda'];

		
		$sql = "	select c.nome
					from 	encomendas e
					inner join clientes c on c.cod_cliente = e.cod_cliente 
					where	e.num_encomenda = $num_encomenda		
				";

		$r = $pdo->query($sql);

		if( $dados = $r->fetch(PDO::FETCH_ASSOC) ) {

			echo 'Cliente ' .'<strong>' . strtoupper($dados['nome']) . '</strong> <br>';
			//echo 'Valor de Venda: R$ '.number_format($dados['valor_unitario'],2,',','.') .' <br>';
			echo '<small>Itens Encomenda</small>';	
		}
		else {
			echo 'Itens Encomenda';
		}

	} // if( $_POST['tipo'] == 'encomenda_descricao_do_encomenda')	

	// Listagem da Encomenda ----------------------------------------------------
	if( $_POST['tipo'] == 'itens_encomenda_listar')
	{
		
		$num_encomenda = $_POST['num_encomenda'];

		include_once('itens_encomenda_form.php');
		
		$sql = "	select ie.* , p.descricao as prato, p.valor_unitario
					from 	itens_encomenda ie 
							inner join pratos p on (ie.cod_prato = p.cod_prato)
							inner join encomendas e on (e.num_encomenda = ie.num_encomenda)
					where	ie.num_encomenda = '$num_encomenda'		
					order by prato
		";

		$r = $pdo->query($sql);

		if( $r->rowCount() == 0 )
		{
			echo 'Está encomenda ainda não possui itens!';
			exit;
		}

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Prato</strong></td>';
		echo ' <td class="text-right"><strong>Quantidade</strong></td>';
		echo ' <td class="text-right"><strong>Valor Unitário</strong></td>';
		echo ' <td class="text-right"><strong>Valor de Custo</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		$vl_custo = 0;
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			echo '<tr class="active">';
			echo ' <td>'.$dados['prato'].'</td>';
			echo ' <td class="text-right">'. number_format($dados['quantidade'],2,',','.') .'</td>';
			echo ' <td class="text-right">'. number_format($dados['valor_unitario'],2,',','.') .'</td>';
			echo ' <td class="text-right">'. number_format($dados['valor_unitario'] * $dados['quantidade'],2,',','.') .'</td>';
			echo ' <td class="text-center">';
			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir_itens_encomenda('.$dados['num_encomenda'].','.$dados['cod_prato'].');">Excluir</a>';
			echo ' </td>';
			echo '</tr>';

			$vl_custo += $dados['quantidade'] * $dados['valor_unitario'];
		}

		echo '<tr class="active">';
		echo ' <td colspan="3"><strong>Valor Total de Custo da Encomenda</strong></td>';
		echo ' <td colspan="1" class="text-right"><strong style="color:#f00;">R$ '.number_format($vl_custo,2,',','.') .'</strong></td>';
		echo ' <td colspan="1"></td>';
		echo '</tr>';

		echo ' <td colspan="1"></td>';
		echo '</tr>';

		echo "</table>";

	} // if( $_POST['tipo'] == 'itens_encomenda_listar')

	// Incluir Item da encomenda ----------------------------------------------------
	if( $_POST['tipo'] == 'intens_encomenda_incluir')
	{
		$num_encomenda    = $_POST['num_encomenda'];		
		$cod_prato  	  = $_POST['cod_prato'];
		$qde 			  = floatUSA($_POST['qde']);
		$valor_total 	  = floatUSA($_POST['valor_total']);
		
		$sql = "	INSERT into itens_encomenda (num_encomenda, cod_prato, quantidade, valor_unitario)
					VALUES ('$num_encomenda', '$cod_prato', '$qde' , 
					(select valor_unitario from pratos where cod_prato = $cod_prato)
					)
				";

		$cmd = $pdo->prepare($sql);
		$r = $cmd->execute();

		

		$sql1 = "	UPDATE encomendas 
						SET valor_total = 
							(	SELECT sum(itens_encomenda.quantidade * itens_encomenda.valor_unitario) 
							 	FROM itens_encomenda 
							 	WHERE num_encomenda = $num_encomenda
							) 
					WHERE num_encomenda = $num_encomenda
				";

		$cmd1 =  $pdo->prepare($sql1);
		$r1 = $cmd1->execute();

		if( !$r ){
			echo '<span style="color:#f00;">Não foi possível incluir este item !</span>';
		}
		else{
			echo '';
		}


	} // if( $_POST['tipo'] == 'itens_encomenda_incluir')


	// Excluir Item da Encomenda ----------------------------------------------------
	if( $_POST['tipo'] == 'itens_encomenda_excluir')
	{
		
		$num_encomenda = $_POST['num_encomenda'];
		$cod_prato = $_POST['cod_prato'];

		$sql = "	DELETE from itens_encomenda 							
					where	num_encomenda = '$num_encomenda' and 	
							cod_prato = '$cod_prato'  
				";

		$cmd = $pdo->prepare($sql);
		$r = $cmd->execute();

		$sql1 = "	UPDATE encomendas 
						SET valor_total = 
							(	SELECT sum(itens_encomenda.quantidade * itens_encomenda.valor_unitario) 
							 	FROM itens_encomenda 
							 	WHERE num_encomenda = $num_encomenda
							) 
					WHERE num_encomenda = $num_encomenda
				";

		$cmd1 =  $pdo->prepare($sql1);
		$r1 = $cmd1->execute();

		if( !$r ){
			echo '<span style="color:#f00;">Não foi possível excluir este item !</span>';
		}
		else{
			echo '';
		}


	} // if( $_POST['tipo'] == 'itens_compra_excluir')

//---------------------------------------Fim Itens Encomenda------------------------------------------------------//