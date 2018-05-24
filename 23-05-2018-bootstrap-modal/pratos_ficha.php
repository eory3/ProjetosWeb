<?php
	$cod_prato = @$_GET['cod_prato'];
	$acao = @$_GET['acao'];

	$descricao                    = '';
	$valor_unitario          = '';
	$cod_categoria              = '';

	if( $acao == 'alterar' )
	{
		$sql = "select * from pratos where cod_prato = '$cod_prato'";
		$r = $pdo->query($sql);		
		if( $d = $r->fetch(PDO::FETCH_ASSOC))
		{
			$descricao   		     = $d['descricao'];
			$valor_unitario          = floatBR($d['valor_unitario']);
			$cod_categoria           = $d['cod_categoria'];

		} // se encontrar o registro para edição 
		else 
		{
			header('Location: pratos.php?msg=prato não encontrado!');
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
			$('#div_erro_descricao').html('O descricao do prato deve ser preenchido !');
			erros++;
		}


		if( !numReal($('#valor_unitario').val()) )
		{
			$('#div_erro_valor_unitario').html('O valor do prato deve conter um número válido !');
			erros++;
		}


		if( $.trim($('#cod_categoria').val()) == '' ) 
		{
			$('#div_erro_cod_categoria').html('A categoria deve ser informada !');
			erros++;
		}


		if( erros > 0 ) {
			$('#div_erro_geral').html('Não foi possível gravar as informações, pois houve ' + erros + ' erro(s) !!!');
		}

		return erros == 0;

	}); // submit do fcad

}); // ready

</script>


<div class="container">

	<div class="page-header">
		<h1>Pratos <small>Ficha</small></h1>
	</div>	


	<div class="row">
		<div class="col-md-12">

			<form  name="fcad" id="fcad" method="POST" action="pratos_gravar.php?acao=<?php echo $acao; ?>&cod_prato=<?php echo $cod_prato; ?>">

			<div class="form-group">	
				<label for="descricao">Descrição:</label><br>
				<input type="text" name="descricao" id="descricao" maxlength="100" size="60" value="<?php echo $descricao; ?>" class="form-control"  placeholder="Informe uma descrição para o prato">
				<div id="div_erro_descricao"></div>
			</div>


			<div class="form-group">	
				<label for="valor_unitario">Valor Unitário:</label><br>
				<input type="text" name="valor_unitario" id="valor_unitario" size="20" value="<?php echo $valor_unitario; ?>" class="form-control"  placeholder="Valor unitário do prato">
				<div id="div_erro_valor_unitario"></div>   
			</div>


			<div class="form-group">	
				<label for="cod_categoria">Categoria:</label><br>
				<select name="cod_categoria" id="cod_categoria" class="form-control" >
					<option value=''>Selecione uma categoria</option>
					<?php
						$r = $pdo->query("select * from categorias order by descricao");		
						while($d = $r->fetch(PDO::FETCH_ASSOC)) 
						{
							$s = $d['cod_categoria'] == $cod_categoria ? ' selected="selected" ' : '';
							echo "<option value='$d[cod_categoria]'  $s > $d[descricao] </option>";
						}
					?>
				</select>
				<div id="div_erro_cod_categoria"></div>   
			</div>

			<p></p>

			<div id="div_erro_geral"></div>

			<p></p>

			<input type="submit" name="btenvio" id="btenvio" value=" Gravar " class="btn btn-success">

			<input type="button" name="btcancelar" id="btcancelar" 
			   value=" Cancelar " onclick="document.location='index.php?modulo=pratos';" class="btn btn-danger">

			</form>
			

		</div>
	</div>

</div>