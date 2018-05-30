<script type="text/javascript">

// exclui um registro --------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir esse fornecedor ??') )
	{
		document.location='fornecedor_gravar.php?acao=excluir&cod_fornecedor='+codigo;
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
	<h1>Fornecedores <small>Listagem</small></h1>
</div>
<div class="row">
	<div class="col-md-12">
		<form name="fpesq" id="fpesq" method="post" action="">

			<?php
				$pesquisa = @$_POST['txtPesquisa'];
			?>
			<div class="form-group">
				<label for="txtPesquisa">Pesquisa:</label>
				<input type="text" name="txtPesquisa" placeholder="Digite sua pesquisa" class="form-control" id="txtPesquisa" size="40" value="<?php echo $pesquisa; ?>">
			</div>

			<input type="submit" class="btn btn-primary" name="btenviar" id="btenviar" value="Pesquisar">
		
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
					 from fornecedores 
					 where nome_fantasia like '%$pesquisa%'
					 order by nome_fantasia";

			// enviando um comando SQL para o banco de dados
			$r = $pdo->query($sql);

			if( !$r ) die('Problemas com o SQL !');

			echo '<table class="table table-hover">';
			echo '<tr>';
			echo ' <td><strong>Código</strong></td>';
			echo ' <td><strong>Nome Fantasia</strong></td>';
			echo ' <td class="text-center"><strong>Opções</strong></td>';
			echo '</tr>';

			// obtendo o próximo registro da consulta
			while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
			{
				echo '<tr  class="active">';
				echo ' <td>'.$dados['cod_fornecedor'].'</td>';
				echo ' <td>'.$dados['nome_fantasia'] . '</td>';

				echo ' <td class="text-center">';
				
				echo '<a class="btn btn-warning btn-xs" href="index.php?modulo=fornecedores_ficha&acao=alterar&cod_fornecedor='.$dados['cod_fornecedor'].'">Alterar</a>';
				
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';

				//echo '<a href="clientes_gravar.php?acao=excluir&cod_cliente='.$dados['cod_cliente'].'">Excluir</a>';

				echo '<a class="btn btn-danger btn-xs" href="javascript:excluir('.$dados['cod_fornecedor'].');">Excluir</a>';

				echo '</td>';

				echo '</tr>';
			} // while

			echo '</table>';

			echo '<p><a class="btn btn-success" href="index.php?modulo=fornecedores_ficha&acao=incluir">Incluir Novo Fornecedor</a></p>';
		?>
	</div>
</div>