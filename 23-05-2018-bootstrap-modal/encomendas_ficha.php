<?php
$num_encomenda = @$_GET['num_encomenda'];
$acao = @$_GET['acao'];

$cod_cliente    = '';
$data           = '';

if( $acao == 'alterar' )
{
	$sql = "select * from encomendas where num_encomenda = $num_encomenda";
	$r = $pdo->query($sql);		
	if( $d = $r->fetch(PDO::FETCH_ASSOC))
	{
		$cod_cliente	= $d['cod_cliente'];
		$data           = dataBR($d['data']);

		} // se encontrar o registro para edição 
		else 
		{
			header('Location: encomendas.php?msg=Encomenda não encontrada!');
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
		if( $.trim($('#cod_cliente').val()) == "")
		{
			$('#div_erro_cod_cliente').html('O cliente deve ser preenchido !');
			erros++;
		}

		if ($.trim($('#data').val()) == "") 
		{
			$('#div_erro_data').html('A data deve ser preenchida !');
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
		<h1>Cadastro de Encomenda <small>Ficha</small></h1>
	</div>	


	<div class="row">
		<div class="col-md-12">

			<form  name="fcad" id="fcad" method="POST" action="encomendas_gravar.php?acao=<?php echo $acao; ?>&num_encomenda=<?php echo $num_encomenda; ?>">

				<div class="form-group">	
					<label for="cod_cliente">Cliente:</label><br>
					<select name="cod_cliente" id="cod_cliente" class="form-control" >
						<option value=''>Selecione um cliente</option>
						<?php
						$r = $pdo->query("select * from clientes order by nome");		
						while($d = $r->fetch(PDO::FETCH_ASSOC)) 
						{
							$s = $d['cod_cliente'] == $cod_cliente ? ' selected="selected" ' : '';
							echo "<option value='$d[cod_cliente]'  $s > $d[nome] </option>";
						}
						?>
					</select>
					<div id="div_erro_cod_cliente"></div>   
				</div>

				<div class="form-group">	
					<label for="data">Data:</label><br>
					<input type="text" name="data" id="data" size="20" value="<?php echo $data; ?>" class="form-control"  placeholder="Informe a data">
					<div id="div_erro_data"></div>   
				</div>	

				<p></p>

				<div id="div_erro_geral"></div>

				<p></p>

				<input type="submit" name="btenvio" id="btenvio" value=" Gravar " class="btn btn-success">

				<input type="button" name="btcancelar" id="btcancelar" 
				value=" Cancelar " onclick="document.location='index.php?modulo=encomendas';" class="btn btn-danger">

			</form>
			

		</div>
	</div>

</div>