<script type="text/javascript">

// exclui um registro --------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir esse ingrediente ??') )
	{
		document.location='ingredientes_gravar.php?acao=excluir&cod_ingrediente='+codigo;
	}
}


//-Quando a página estiver totalmente carregada --------
$(document).ready( function(){ 

	// colocando o foco na caixa de edição da pesquisa 
	$('#txtPesquisa').focus();
	$('#txtPesquisa').select();
    
}); // ready

</script>

		<div class="page-header">
			<h1>Ingredientes <small>Listagem</small></h1>
		</div>	

<div class="row">
	<div class="col-md-12">

		<form name="fpesq" id="fpesq" method="post" action=""> <!--class="form-inline" -->

			<?php
			$pesquisa = @$_POST['txtPesquisa'];
			?>

			<div class="form-group">
				<label for="txtPesquisa">Pesquisa:</label>
				<input class="form-control" type="text" placeholder="Digite sua pesquisa" name="txtPesquisa" id="txtPesquisa" size="40" value="<?php echo $pesquisa; ?>">
			</div>

			<input type="submit" name="btenviar" id="btenviar" value="Pesquisar" class="btn btn-primary">

		</form>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">


		<?php

		// se a variável $_GET['msg'] existir
		if( isset($_GET['msg']) )
		{
			echo '<p style="color:#f00;">' . $_GET['msg'] . '</p>';
		}

		$sql = " 
				SELECT ing.cod_ingrediente, 
					ing.descricao, 
					ing.valor_unitario, 
					unid.descricao as unidade 
				FROM `ingredientes` as ing 
				INNER JOIN unidades as unid on unid.cod_unidade = ing.cod_unidade";

		$r = $pdo->query($sql);

		if( !$r ) die('Problemas..., tente mais tarde !');

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Código</strong></td>';
		echo ' <td><strong>Descrição</strong></td>';
		echo ' <td><strong>Valor Unitario</strong></td>';
		echo ' <td><strong>Unidade</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			echo '<tr class="active">';
			echo ' <td>'.$dados['cod_ingrediente'].'</td>';
			echo ' <td>'.$dados['descricao'].'</td>';
			echo ' <td>'.$dados['valor_unitario'].'</td>';
			echo ' <td>'.$dados['unidade'].'</td>';

			echo ' <td class="text-center">';
			
			echo '<a class="btn btn-warning btn-xs" href="index.php?modulo=ingredientes_ficha&acao=alterar&cod_ingrediente='.$dados['cod_ingrediente'].'">Alterar</a>';
			
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';

			//echo '<a href="ingredientes_gravar.php?acao=excluir&cod_ingrediente='.$dados['cod_ingrediente'].'">Excluir</a>';

			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir('.$dados['cod_ingrediente'].');">Excluir</a>';

			echo '</td>';

			echo '</tr>';
		} // while

		echo '</table>';

		echo '<a href="index.php?modulo=ingredientes_ficha&acao=incluir"  class="btn btn-success">Incluir Nova Unidade</a>';

		echo '<br><br>';
		?>
	</div>
</div>