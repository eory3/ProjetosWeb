<script type="text/javascript">

// abre a janela modal ------------------------------------------------------------------
function AbrirComposicao(cod_prato)
{
	$('#TitleComposicao').html('Composição do Prato: ' + cod_prato);

	$('#ListaComposicao').load('webservice.php',{tipo:'composicao_listar',cod_prato:cod_prato}, 
		function(){
			// Abrindo a Janela Modal de Composição
			$('#ModalComposicao').modal();

	});

}

// exclui um ingrediente da composição ------------------------------------------------------------------
function excluir_ingrediente(cod_prato, cod_ingrediente)
{

	if( confirm('Deseja realmente excluir esse ingrediente desta composição ?') )
	{
		$.post('webservice.php',{tipo:'composicao_excluir',cod_prato:cod_prato,cod_ingrediente:cod_ingrediente},
				function(){
					$('#ListaComposicao').load('webservice.php',{tipo:'composicao_listar',cod_prato:cod_prato});
		});
				
	}
	
}

// exclui um registro ------------------------------------------------------------------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir essa prato ??') )
	{
		document.location='pratos_gravar.php?acao=excluir&cod_prato='+codigo;
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
	<h1>Pratos <small>Listagem</small></h1>
</div>	

<div class="row">
	<div class="col-md-12">

		<form name="fpesq" id="fpesq" method="post" action=""> <!--class="form-inline" -->

			<?php
			$pesquisa = @$_POST['txtPesquisa'];
			?>

			<div class="form-group">
				<label for="txtPesquisa">Pesquisa:</label>
				<input type="text" class="form-control" placeholder="Digite sua pesquisa" name="txtPesquisa" id="txtPesquisa" size="40" value="<?php echo $pesquisa; ?>">
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

		$sql = "	select p.*, c.descricao as categoria
					from 	pratos p
							left outer join categorias c on (p.cod_categoria = c.cod_categoria)
					where p.descricao like '%$pesquisa%' or c.descricao like '%$pesquisa%'			
					order by p.descricao
				";

		$r = $pdo->query($sql);

		if( !$r ) die('Problemas..., tente mais tarde !');

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Código</strong></td>';
		echo ' <td><strong>Descrição</strong></td>';
		echo ' <td><strong>Categoria</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			echo '<tr class="active">';
			echo ' <td>'.$dados['cod_prato'].'</td>';
			echo ' <td>'.$dados['descricao'] .'</td>';
			echo ' <td>'.$dados['categoria'] .'</td>';

			echo ' <td class="text-center">';

			/*
			echo '<a class="btn btn-primary btn-xs" href="#" data-toggle="modal" data-target="#ModalComposicao">Composição</a>';
			*/
			
			echo '<a class="btn btn-primary btn-xs" href="javascript:AbrirComposicao('.$dados['cod_prato'].');">Composição</a>';


			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			
			echo '<a class="btn btn-warning btn-xs" href="index.php?modulo=pratos_ficha&acao=alterar&cod_prato='.$dados['cod_prato'].'">Alterar</a>';
			
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';

			//echo '<a href="pratos_gravar.php?acao=excluir&cod_prato='.$dados['cod_prato'].'">Excluir</a>';

			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir('.$dados['cod_prato'].');">Excluir</a>';

			echo '</td>';

			echo '</tr>';
		} // while

		echo '</table>';

		echo '<a href="index.php?modulo=pratos_ficha&acao=incluir"  class="btn btn-success">Incluir um Novo Registro</a>';


		?>

	</div>
</div>




<!-- COMPOSIÇÃO MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalComposicao">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="TitleComposicao">Composição</h4>
      </div>
      <div class="modal-body" id="BodyComposicao">
      		<!-- formulário para selecionar o ingrediente e a qde -->

      		<div id="ListaComposicao"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->










