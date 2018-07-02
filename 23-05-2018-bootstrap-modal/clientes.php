<script type="text/javascript">

// exclui um registro --------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir esse cliente ??') )
	{
		document.location='clientes_gravar.php?acao=excluir&cod_cliente='+codigo;
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
	<h1>Clientes <small>Listagem</small></h1>
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
					 from clientes 
					 where nome like '%$pesquisa%'
					 order by nome";

			// enviando um comando SQL para o banco de dados
			$r = $pdo->query($sql);

			if( !$r ) die('Problemas com o SQL !');

			echo '<table class="table table-hover">';
			echo '<tr>';
			echo ' <td><strong>Código</strong></td>';
			echo ' <td><strong>Nome</strong></td>';
			echo ' <td class="text-center"><strong>Opções</strong></td>';
			echo '</tr>';

			// obtendo o próximo registro da consulta
			while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
			{
				echo '<tr  class="active">';
				echo ' <td>'.$dados['cod_cliente'].'</td>';
				echo ' <td>'.$dados['nome'] . '</td>';

				echo ' <td class="text-center">';
				
				echo '<a class="btn btn-warning btn-xs" href="index.php?modulo=clientes_ficha&acao=alterar&cod_cliente='.$dados['cod_cliente'].'">Alterar</a>';
				
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';

				//echo '<a href="clientes_gravar.php?acao=excluir&cod_cliente='.$dados['cod_cliente'].'">Excluir</a>';

				echo '<a class="btn btn-danger btn-xs" href="javascript:excluir('.$dados['cod_cliente'].');">Excluir</a>';

				echo '</td>';

				echo '</tr>';
			} // while

			echo '</table>';

			echo '<p><a class="btn btn-success" href="index.php?modulo=clientes_ficha&acao=incluir">Incluir Novo Cliente</a></p>';
		?>
	</div>
</div>