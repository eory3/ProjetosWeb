<?php
$cod_compra = @$_GET['cod_compra'];
$acao = @$_GET['acao'];

$nota_fiscal           = '';
$data           = '';
$cod_fornecedor = '';
$nota_serie     = '';

if( $acao == 'alterar' )
{
	$sql = "select * from compras where cod_compra = '$cod_compra'";
	$r = $pdo->query($sql);		
	if( $d = $r->fetch(PDO::FETCH_ASSOC))
	{
		$nota_fiscal	= $d['nota_fiscal'];
		$data           = dataBR($d['data']);
		$cod_fornecedor = $d['cod_fornecedor'];
		$nota_serie     = $d['nota_serie'];

		} // se encontrar o registro para edição 
		else 
		{
			header('Location: compras.php?msg=Compra não encontrada!');
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
		if( $.trim($('#nota_fiscal').val()) == "")
		{
			$('#div_erro_nota_fiscal').html('A nota fiscal deve ser preenchida !');
			erros++;
		}

		if ($.trim($('#nota_serie').val()) == "") 
		{
			$('#div_erro_nota_serie').html('O numero de serie deve ser preenchido !');
			erros++;
		}

		if ($.trim($('#data').val()) == "") 
		{
			$('#div_erro_data').html('A data deve ser preenchida !');
			erros++;
		}

		if( $.trim($('#cod_fornecedor').val()) == '' ) 
		{
			$('#div_erro_cod_fornecedor').html('O fornecedor de ser informado !');
			erros++;
		}


		if( erros > 0 ) {
			$('#div_erro_geral').html('Não foi possível gravar as informações, pois houve ' + erros + ' campo(s) com informação(ões) incorreta(s) !!!');
		}

		return erros == 0;

	}); // submit do fcad

}); // ready

</script>


<div class="container">

	<div class="page-header">
		<h1>Cadastro de Compra <small>Ficha</small></h1>
	</div>	


	<div class="row">
		<div class="col-md-12">

			<form  name="fcad" id="fcad" method="POST" action="compras_gravar.php?acao=<?php echo $acao; ?>&cod_compra=<?php echo $cod_compra; ?>">

				<div class="form-group">	
					<label for="nota_fiscal">Nota Fiscal:</label><br>
					<input type="text" name="nota_fiscal" id="nota_fiscal" maxlength="100" size="60" value="<?php echo $nota_fiscal; ?>" class="form-control"  placeholder="Informe a nota fiscal da compra">
					<div id="div_erro_nota_fiscal"></div>
				</div>

				<div class="form-group">	
					<label for="nota_serie">Serie:</label><br>
					<input type="text" name="nota_serie" id="nota_serie" size="20" value="<?php echo $nota_serie; ?>" class="form-control"  placeholder="Informe a serie da nota">
					<div id="div_erro_nota_serie"></div>   
				</div>


				<div class="form-group">	
					<label for="data">Data:</label><br>
					<input type="text" name="data" id="data" size="20" value="<?php echo $data; ?>" class="form-control"  placeholder="Informe a data">
					<div id="div_erro_data"></div>   
				</div>


				<div class="form-group">	
					<label for="cod_fornecedor">Fornecedor:</label><br>
					<select name="cod_fornecedor" id="cod_fornecedor" class="form-control" >
						<option value=''>Selecione uma fornecedor</option>
						<?php
						$r = $pdo->query("select * from fornecedores order by nome_fantasia");		
						while($d = $r->fetch(PDO::FETCH_ASSOC)) 
						{
							$s = $d['cod_fornecedor'] == $cod_fornecedor ? ' selected="selected" ' : '';
							echo "<option value='$d[cod_fornecedor]'  $s > $d[nome_fantasia] </option>";
						}
						?>
					</select>
					<div id="div_erro_cod_fornecedor"></div>   
				</div>

				<p></p>

				<div id="div_erro_geral"></div>

				<p></p>

				<input type="submit" name="btenvio" id="btenvio" value=" Gravar " class="btn btn-success">

				<input type="button" name="btcancelar" id="btcancelar" 
				value=" Cancelar " onclick="document.location='index.php?modulo=compras';" class="btn btn-danger">

			</form>
			

		</div>
	</div>

</div>