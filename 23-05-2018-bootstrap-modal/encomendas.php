<script type="text/javascript">

// abre a janela modal ------------------------------------------------------------------
function AbrirItensEncomenda(num_encomenda)
{
	$('#TitleItensEncomenda').load('webservice.php',{tipo:'itens_encomenda_descricao_da_encomenda',num_encomenda:num_encomenda});

	$('#div_msg_itens_encomenda').html('Carregando... <br><img src="_images/ajax-loader3.gif">');

	$('#ListaItensEncomenda').load('webservice.php',{tipo:'itens_encomenda_listar',num_encomenda:num_encomenda}, 
		function(){
			$('#div_msg_itens_encomenda').html('');

			// Abrindo a Janela Modal de Encomeda
			$('#ModalItensEncomenda').modal();

	});

} // AbrirEncomenda

// inclui um item na encomenda ------------------------------------------------------------------
function incluir_itens_encomenda(num_encomenda)
{
	$('div[id*="div_erro"').css('color','#f00');
	//$('div[id*="div_erro"').css('padding-bottom', '20px');

	// limpando as mensagens de erro
	$('div[id*="div_erro"').html('');

	erros = 0;
	if( $.trim($('#cod_prato').val()) == "")
	{
		$('#div_erro_cod_prato').html('O prato deve ser selecionado!');
		erros++;
	}

	if( !numReal($('#qde').val()) )
	{
		$('#div_erro_qde').html('A quantidade deve ser um número válido!');
		erros++;
	}

	if( erros == 0 )
	{
		$('#div_msg_itens_encomenda').html('Enviando os dados... <br><img src="_images/ajax-loader3.gif">');

		$.post('webservice.php',{tipo:'intens_encomenda_incluir',num_encomenda:num_encomenda,cod_prato:$('#cod_prato').val(),qde:$('#qde').val()},
				function(retorno){
					$('#ListaItensEncomenda').load('webservice.php',{tipo:'itens_encomenda_listar',num_encomenda:num_encomenda});
					$('#div_msg_itens_encomenda').html(retorno);
		});
				
	}

} // incluir_encomenda

// exclui um item da encomenda ------------------------------------------------------------------
function excluir_itens_encomenda(num_encomenda, cod_prato)
{
	if( confirm('Deseja realmente excluir esse prato desta encomenda ?') )
	{
		$('#div_msg_itens_encomenda').html('Excluindo o item... <br><img src="_images/ajax-loader3.gif">');		

		$.post('webservice.php',{tipo:'itens_encomenda_excluir',num_encomenda:num_encomenda,cod_prato:cod_prato},
				function(retorno){

					$('#ListaItensEncomenda').load('webservice.php',{tipo:'itens_encomenda_listar',num_encomenda:num_encomenda});
					$('#div_msg_itens_encomenda').html(retorno);
		});
				
	}
	
} // excluir_ingrediente

// exclui um registro ------------------------------------------------------------------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir essa encomenda ??') )
	{
		document.location='encomendas_gravar.php?acao=excluir&num_encomenda='+codigo;
	}
} // excluir


//-Quando a página estiver totalmente carregada --------
$(document).ready( function(){ 

	// colocando o foco na caixa de edição da pesquisa 
	$('#txtPesquisa').focus();
	$('#txtPesquisa').select();

	//recarregando tabela quando o modal fechar
	$('#ModalItensEncomenda').on('hidden.bs.modal', function () {
    	window.location.reload();
	});
    
}); // ready

</script>

<div class="page-header">
	<h1>Encomendas <small>Listagem</small></h1>
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

		$sql = "
					SELECT e.num_encomenda, c.nome as nome, e.data, e.valor_total 
					from encomendas e 
					LEFT outer JOIN clientes c on e.cod_cliente = c.cod_cliente 
					ORDER by e.num_encomenda;
				";

		$r = $pdo->query($sql);

		if( !$r ) die('Problemas..., tente mais tarde !');

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Código</strong></td>';
		echo ' <td><strong>Cliente</strong></td>';
		echo ' <td><strong>Data</strong></td>';
		echo ' <td  class="text-right"><strong>Valor Total</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			
			echo '<tr class="active">';
			echo ' <td>'.$dados['num_encomenda']  .'</td>';
			echo ' <td>'.$dados['nome'] .'</td>';
			echo ' <td>'.dataBR($dados['data']).'</td>';

			echo ' <td class="text-right"> R$ '.number_format($dados['valor_total'],2,',','.') .' </td>';

			echo ' <td class="text-center">';
			
			echo '<a class="btn btn-primary btn-xs" href="javascript:AbrirItensEncomenda('.$dados['num_encomenda'].');">Itens Encomenda</a>';


			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			
			echo '<a class="btn btn-warning btn-xs" href="index.php?modulo=encomendas_ficha&acao=alterar&num_encomenda='.$dados['num_encomenda'].'">Alterar</a>';
			
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';

			//echo '<a href="compras_gravar.php?acao=excluir&num_encomenda='.$dados['num_encomenda'].'">Excluir</a>';

			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir('.$dados['num_encomenda'].');">Excluir</a>';

			echo '</td>';

			echo '</tr>';
		} // while

		echo '</table>';

		echo '<a href="index.php?modulo=encomendas_ficha&acao=incluir"  class="btn btn-success">Incluir uma Nova Encomenda</a>';


		?>

	</div>
</div>




<!-- COMPOSIÇÃO MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalItensEncomenda">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="TitleItensEncomenda">Itens Encomenda</h4>
      </div>
      <div class="modal-body" id="BodyEncomenda">
      		<!-- formulário para selecionar o ingrediente e a qde -->

      		<div id="ListaItensEncomenda"></div>
      		<div id="div_msg_itens_encomenda"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->










