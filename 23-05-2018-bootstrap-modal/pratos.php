<script type="text/javascript">

// abre a janela modal ------------------------------------------------------------------
function AbrirComposicao(cod_prato)
{
	$('#TitleComposicao').load('webservice.php',{tipo:'composicao_descricao_do_prato',cod_prato:cod_prato});

	$('#div_msg_composicao').html('Carregando... <br><img src="_images/ajax-loader3.gif">');

	$('#ListaComposicao').load('webservice.php',{tipo:'composicao_listar',cod_prato:cod_prato}, 
		function(){
			$('#div_msg_composicao').html('');

			// Abrindo a Janela Modal de Composição
			$('#ModalComposicao').modal();

	});

} // AbrirComposicao

// inclui um ingrediente na composição ------------------------------------------------------------------
function incluir_ingrediente(cod_prato)
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
		$('#div_msg_composicao').html('Enviando os dados... <br><img src="_images/ajax-loader3.gif">');

		$.post('webservice.php',{tipo:'composicao_incluir',cod_prato:cod_prato,cod_ingrediente:$('#cod_ingrediente').val(),qde:$('#qde').val()},
				function(retorno){
					$('#ListaComposicao').load('webservice.php',{tipo:'composicao_listar',cod_prato:cod_prato});
					$('#div_msg_composicao').html(retorno);
		});
				
	}

} // incluir_ingrediente

// exclui um ingrediente da composição ------------------------------------------------------------------
function excluir_ingrediente(cod_prato, cod_ingrediente)
{

	if( confirm('Deseja realmente excluir esse ingrediente desta composição ?') )
	{
		$('#div_msg_composicao').html('Excluindo o item... <br><img src="_images/ajax-loader3.gif">');		

		$.post('webservice.php',{tipo:'composicao_excluir',cod_prato:cod_prato,cod_ingrediente:cod_ingrediente},
				function(retorno){

					$('#ListaComposicao').load('webservice.php',{tipo:'composicao_listar',cod_prato:cod_prato});
					$('#div_msg_composicao').html(retorno);
		});
				
	}
	
} // excluir_ingrediente

// exclui um registro ------------------------------------------------------------------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir essa prato ??') )
	{
		document.location='pratos_gravar.php?acao=excluir&cod_prato='+codigo;
	}
} // excluir


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
		echo ' <td  class="text-right"><strong>Valor Unitário</strong></td>';
		echo ' <td  class="text-center"><strong>Opções</strong></td>';
		echo '</tr>';

		// obtendo o próximo registro da consulta
		while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
		{
			echo '<tr class="active">';
			echo ' <td>'.$dados['cod_prato'].'</td>';
			echo ' <td>'.$dados['descricao'] .'</td>';
			echo ' <td>'.$dados['categoria'] .'</td>';

			echo ' <td class="text-right"> R$ '.number_format($dados['valor_unitario'],2,',','.') .' </td>';

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

		echo '<a href="index.php?modulo=pratos_ficha&acao=incluir"  class="btn btn-success">Incluir um Novo Prato</a>';


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
      		<div id="div_msg_composicao"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->










