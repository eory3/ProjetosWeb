<?php
$cod_ingrediente = @$_GET['cod_ingrediente'];
$acao = @$_GET['acao'];

$descricao           = '';
$valor_unitario   	 = '';
$cod_unidade         = '';

if( $acao == 'alterar' )
{
	$sql = "select * from ingredientes where cod_ingrediente = '$cod_ingrediente'";
	$r = $pdo->query($sql);		
	if( $d = $r->fetch(PDO::FETCH_ASSOC))
	{
		$descricao   		 = $d['descricao'];
		$valor_unitario    	 = $d['valor_unitario'];
		$cod_unidade         = ($d['cod_unidade']);

		} // se encontrar o registro para edição 
		else 
		{
			header('Location: ingredientes.php?msg=Ingrediente não encontrado!');
		}
	}


	?>

	<script type="text/javascript">

		$(document).ready(function(){

	// selecionando todos os elementos div que possuem a palavra "div_erro" na propriedade id	
	// atribuindo css
	$('div[id*="div_erro"').css('color','#f00');
	$('div[id*="div_erro"').css('padding-bottom', '20px');

	// Evento SUBMIT do formulário -----------------------------------------------
	$('#fcad').submit(function(){

		// limpando as mensagens de texto
		$('div[id*="div_erro"').html('');

		erros = 0;
		if( $.trim($('#descricao').val()) == "")
		{
			$('#div_erro_descricao').html('A descricao da unidade deve ser preenchida !');
			erros++;
		}

		if( !validavalor_unitario($('#valor_unitario').val()) )
		{
			$('#div_erro_valor_unitario').html('O valor unitario deve ser preenchido !');
			erros++;
		}

		if( $.trim($('#cod_unidade').val()) == '' ) 
		{
			$('#div_erro_cod_unidade').html('A unidade deve ser informada !');
			erros++;
		}

		if( erros > 0 ) {
			$('#div_erro_geral').html('Não foi possível gravar as informações, pois ' + erros + ' campo(s) deve(m) ser preenchido(s) !!!');
		}

		return erros == 0;

	}); // submit do fcad

}); // ready

</script>
<div class="container">
	<div class="page-header">
		<h2>Cadastro de Ingrediente <small>Ficha</small></h2>
	</div>
	<div class="col-md-12">
		<form  name="fcad" id="fcad" method="POST" action="ingredientes_gravar.php?acao=<?php echo $acao; ?>&cod_ingrediente=<?php echo $cod_ingrediente; ?>">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="descricao">Descricao</label>
						<input class="form-control" placeholder="Digite a descrição do ingrediente" type="text" name="descricao" id="descricao" maxlength="100" size="60" value="<?php echo $descricao; ?>">
						<div id="div_erro_descricao"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="valor_unitario">Valor Unitario</label>
						<input class="form-control" placeholder="Digite o seu valor unitario" type="number" step="0.01" name="valor_unitario" id="valor_unitario" maxlength="11" size="20" value="<?php echo $valor_unitario; ?>">
						<div id="div_erro_valor_unitario"></div>   
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="cod_unidade">Unidade</label>
						<select class="form-control" name="cod_unidade" id="cod_unidade">
							<option value=''>Selecione a unidade</option>
							<?php
							$r = $pdo->query("select * from unidades order by descricao");		
							while($d = $r->fetch(PDO::FETCH_ASSOC)) 
							{
								$s = $d['cod_unidade'] == $cod_unidade ? ' selected="selected" ' : '';
								echo "<option value='$d[cod_unidade]'  $s > $d[descricao]</option>";
							}
							?>
						</select>
						<div id="div_erro_cod_unidade"></div>
					</div>
				</div>
			</div>
			<p></p>

			<div id="div_erro_geral"></div>

			<p></p>

			<input class="btn btn-success" type="submit" name="btenvio" id="btenvio" value=" Gravar ">

			<input class="btn btn-danger" type="button" name="btcancelar" id="btcancelar" 
			value=" Cancelar " onclick="document.location='index.php?modulo=ingredientes';">
			<p></p>
		</form>
	</div>
</div>