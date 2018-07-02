<script type="text/javascript">

// abre a janela modal ------------------------------------------------------------------
function AbrirItensCompra(cod_compra)
{
	$('#TitleItensCompra').load('webservice.php',{tipo:'itens_compra_descricao_da_compra',cod_compra:cod_compra});

	$('#div_msg_itens_compra').html('Carregando... <br><img src="_images/ajax-loader3.gif">');

	$('#ListaItensCompra').load('webservice.php',{tipo:'itens_compra_listar',cod_compra:cod_compra}, 
		function(){
			$('#div_msg_itens_compra').html('');

			// Abrindo a Janela Modal de Composição
			$('#ModalItensCompra').modal();

	});

} // AbrirComposicao

// inclui um item na compra ------------------------------------------------------------------
function incluir_itens_compra(cod_compra)
{
	$('div[id*="div_erro"').css('color','#f00');
	//$('div[id*="div_erro"').css('padding-bottom', '20px');

	// limpando as mensagens de erro
	$('div[id*="div_erro"').html('');

	erros = 0;
	if( $.trim($('#cod_ingrediente').val()) == "")
	{
		$('#div_erro_cod_ingrediente').html('O ingrediente deve ser selecionado!');
		erros++;
	}

	if( !numReal($('#qde').val()) )
	{
		$('#div_erro_qde').html('A quantidade deve ser um número válido!');
		erros++;
	}

	if( erros == 0 )
	{
		$('#div_msg_itens_compra').html('Enviando os dados... <br><img src="_images/ajax-loader3.gif">');

		$.post('webservice.php',{tipo:'intens_compra_incluir',cod_compra:cod_compra,cod_ingrediente:$('#cod_ingrediente').val(),qde:$('#qde').val()},
				function(retorno){
					$('#ListaItensCompra').load('webservice.php',{tipo:'itens_compra_listar',cod_compra:cod_compra});
					$('#div_msg_itens_compra').html(retorno);
		});
				
	}

} // incluir_ingrediente

// exclui um item da compra ------------------------------------------------------------------
function excluir_itens_compra(cod_compra, cod_ingrediente)
{
	if( confirm('Deseja realmente excluir esse ingrediente desta compra ?') )
	{
		$('#div_msg_itens_compra').html('Excluindo o item... <br><img src="_images/ajax-loader3.gif">');		

		$.post('webservice.php',{tipo:'itens_compra_excluir',cod_compra:cod_compra,cod_ingrediente:cod_ingrediente},
				function(retorno){

					$('#ListaItensCompra').load('webservice.php',{tipo:'itens_compra_listar',cod_compra:cod_compra});
					$('#div_msg_itens_compra').html(retorno);
		});
				
	}
	
} // excluir_ingrediente

// exclui um registro ------------------------------------------------------------------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir essa compra ??') )
	{
		document.location='compras_gravar.php?acao=excluir&cod_compra='+codigo;
	}
} // excluir


//-Quando a página estiver totalmente carregada --------
$(document).ready( function(){ 

	// colocando o foco na caixa de edição da pesquisa 
	$('#txtPesquisa').focus();
	$('#txtPesquisa').select();

	//recarregando tabela quando o modal fechar
	$('#ModalItensCompra').on('hidden.bs.modal', function () {
    	window.location.reload();
	});
    
}); // ready

</script>

<div class="page-header">
	<h1>Compras <small>Listagem</small></h1>
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

		$sql = "	select 
							c.cod_compra,
							c.nota_fiscal,
							c.data, 
                            c.valor_total,
							f.nome_fantasia as fornecedor
					from 	compras c
							left outer join fornecedores f on (c.cod_fornecedor = f.cod_fornecedor)
					where c.nota_fiscal like '%$pesquisa%' or f.nome_fantasia like '%$pesquisa%'			
					order by c.nota_fiscal
				";

		$r = $pdo->query($sql);

		if( !$r ) die('Problemas..., tente mais tarde !');

		echo '<table class="table table-hover">';
		echo '<tr>';
		echo ' <td><strong>Código</strong></td>';
		echo ' <td><strong>Nota Fiscal</strong></td>';
		echo ' <td><strong>Data</strong></td>';
		echo ' <td><strong>Fornecedor</strong></td>';
		echo ' <td  class="text-right"><strong>Valor Total</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			
			echo '<tr class="active">';
			echo ' <td>'.$dados['cod_compra']  .'</td>';
			echo ' <td>'.$dados['nota_fiscal'] .'</td>';
			echo ' <td>'.dataBR($dados['data']).'</td>';
			echo ' <td>'.$dados['fornecedor']  .'</td>';

			echo ' <td class="text-right"> R$ '.number_format($dados['valor_total'],2,',','.') .' </td>';

			echo ' <td class="text-center">';
			
			echo '<a class="btn btn-primary btn-xs" href="javascript:AbrirItensCompra('.$dados['cod_compra'].');">Itens Compra</a>';


			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			
			echo '<a class="btn btn-warning btn-xs" href="index.php?modulo=compras_ficha&acao=alterar&cod_compra='.$dados['cod_compra'].'">Alterar</a>';
			
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';

			//echo '<a href="compras_gravar.php?acao=excluir&cod_compra='.$dados['cod_compra'].'">Excluir</a>';

			echo '<a class="btn btn-danger btn-xs" href="javascript:excluir('.$dados['cod_compra'].');">Excluir</a>';

			echo '</td>';

			echo '</tr>';
		} // while

		echo '</table>';

		echo '<a href="index.php?modulo=compras_ficha&acao=incluir"  class="btn btn-success">Incluir um Nova Compra</a>';


		?>

	</div>
</div>




<!-- COMPOSIÇÃO MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalItensCompra">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="TitleItensCompra">Itens Compra</h4>
      </div>
      <div class="modal-body" id="BodyComposicao">
      		<!-- formulário para selecionar o ingrediente e a qde -->

      		<div id="ListaItensCompra"></div>
      		<div id="div_msg_itens_compra"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->










