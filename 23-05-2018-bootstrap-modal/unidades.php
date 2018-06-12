<script type="text/javascript">

// exclui um registro --------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir essa unidade ??') )
	{
		document.location='unidades_gravar.php?acao=excluir&cod_unidade='+codigo;
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
			<h1>Unidades <small>Listagem</small></h1>
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

		$sql = " select * 
		from unidades 
		where descricao like '%$pesquisa%'
		order by descricao";

		$r = $pdo->query($sql);

		if( !$r ) die('Problemas..., tente mais tarde !');

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Código</strong></td>';
		echo ' <td><strong>Descrição</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			echo '<tr class="active">';
			echo ' <td>'.$dados['cod_unidade'].'</td>';
			echo ' <td>'.$dados['descricao'].'</td>';

			echo ' <td class="text-center">';
			
			echo '<a class="btn btn-warning btn-xs" href="index.php?modulo=unidades_ficha&acao=alterar&cod_unidade='.$dados['cod_unidade'].'">Alterar</a>';
			
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';

			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir('.$dados['cod_unidade'].');">Excluir</a>';

			echo '</td>';

			echo '</tr>';
		} // while

		echo '</table>';

		echo '<a href="index.php?modulo=unidades_ficha&acao=incluir"  class="btn btn-success">Incluir Nova Unidade</a>';


		?>

	</div>
</div>