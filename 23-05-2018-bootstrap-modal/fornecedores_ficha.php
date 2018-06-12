<?php
$cod_fornecedor = @$_GET['cod_fornecedor'];
$acao = @$_GET['acao'];

$razao_social       = '';
$nome_fantasia   	= '';
$cnpj               = '';
$inscricao_estadual = '';
$endereco           = '';
$bairro             = '';
$cod_cidade         = '';
$cep                = '';
$telefone           = '';
$celular            = '';
$email              = '';

if( $acao == 'alterar' )
{
	$sql = "select * from fornecedores where cod_fornecedor = '$cod_fornecedor'";
	$r = $pdo->query($sql);		
	if( $d = $r->fetch(PDO::FETCH_ASSOC))
	{
		$razao_social		= $d['razao_social'];
		$nome_fantasia   	= $d['nome_fantasia'];
		$cnpj    		    = $d['cnpj'];
		$inscricao_estadual = $d['inscricao_estadual'];
		$endereco           = $d['endereco'];
		$bairro             = $d['bairro'];
		$cod_cidade         = $d['cod_cidade'];
		$cep                = $d['cep'];
		$telefone           = $d['telefone'];
		$celular            = $d['celular'];
		$email              = $d['email'];

		} // se encontrar o registro para edição 
		else 
		{
			header('Location: fornecedores.php?msg=Fornecedor não encontrado!');
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
		if( $.trim($('#razao_social').val()) == "")
		{
			$('#div_erro_razao_social').html('A razão social deve ser preenchido !');
			erros++;
		}

		if( $.trim($('#nome_fantasia').val()) == "")
		{
			$('#div_erro_nome_fantasia').html('O nome fantasia deve ser preenchido ! !');
			erros++;
		}

		if( $.trim($('#cnpj').val()) == "")
		{
			$('#div_erro_cnpj').html('O cnpj deve ser preenchido !');
			erros++;
		}

		if( $.trim($('#inscricao_estadual').val()) == "")
		{
			$('#div_erro_inscricao_estadual').html('A inscricao estadual deve ser preenchido !');
			erros++;
		}

		if ( $.trim($('#endereco').val()) == "")
		{
			$('#div_erro_endereco').html('O endereço deve ser preenchido !');
			erros++;
		}

		if( $.trim($('#bairro').val()) == "")
		{
			$('#div_erro_bairro').html('O bairro deve ser preenchido !');
			erros++;
		}

		if( $.trim($('#cod_cidade').val()) == "")
		{
			$('#div_erro_cod_cidade').html('A cidade deve ser informada !');
			erros++;
		}

		if( $.trim($('#cep').val()) == '' ) 
		{
			$('#div_erro_cep').html('O cep deve ser informado !');
			erros++;
		}

		if( $.trim($('#telefone').val()) == '' && $.trim($('#celular').val()) == '' ) 
		{
			$('#div_erro_telefone').html('Pelo menos um dos telefones deve ser preenchido !');
			$('#div_erro_celular').html(  $('#div_erro_telefone').html()  );
			erros++;
		}

		if( !ValidaEmail($('#email').val()) )
		{
			$('#div_erro_email').html('E-mail inválido !');
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
		<h2>Cadastro de Fornecedor <small>Ficha</small></h2>
	</div>
	<div class="col-md-12">
		<form  name="fcad" id="fcad" method="POST" action="fornecedores_gravar.php?acao=<?php echo $acao; ?>&cod_fornecedor=<?php echo $cod_fornecedor; ?>">

			<div class="form-group">
				<label for="nome">Razão Social</label>
				<input class="form-control" placeholder="Digite a razão social" type="text" name="razao_social" id="razao_social" maxlength="100" value="<?php echo $razao_social; ?>">
				<div id="div_erro_razao_social"></div>
			</div>
			<div class="form-group">
				<label for="cpf">Nome Fantasia</label>
				<input class="form-control" placeholder="Digite o nome fantasia" type="text" name="nome_fantasia" id="nome_fantasia" maxlength="100" value="<?php echo $nome_fantasia; ?>">
				<div id="div_erro_nome_fantasia"></div>   
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="data_nascimento">Inscricão Estadual</label>
						<input class="form-control" placeholder="Digite a inscricao estadual" type="text" name="inscricao_estadual" id="inscricao_estadual" maxlength="20" value="<?php echo $inscricao_estadual; ?>">
						<div id="div_erro_inscricao_estadual"></div>   
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="rg">CNPJ</label>
						<input class="form-control" placeholder="Digite o cnpj" type="text" name="cnpj" id="cnpj" maxlength="20" value="<?php echo $cnpj; ?>">
						<div id="div_erro_cnpj"></div>   
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="telefone">Telefone Fixo</label>
						<input class="form-control" placeholder="Digite o telefone" type="text" name="telefone" id="telefone" maxlength="20" size="20" value="<?php echo $telefone; ?>">
						<div id="div_erro_telefone"></div>   
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="celular">Celular</label>
						<input class="form-control" placeholder="Digite o celular" type="text" name="celular" id="celular" maxlength="20" size="20" value="<?php echo $celular; ?>">
						<div id="div_erro_celular"></div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="email">E-mail</label>
				<input class="form-control" placeholder="Digite o e-mail" type="text" name="email" id="email" maxlength="150" size="70" value="<?php echo $email; ?>">
				<div id="div_erro_email"></div>   
			</div>
			<div class="form-group">
				<label for="data_nascimento">Enedreço</label>
				<input class="form-control" placeholder="Digite o endereço" type="text" name="endereco" id="endereco" maxlength="100" value="<?php echo $endereco; ?>">
				<div id="div_erro_endereco"></div>   
			</div>
			<div class="form-group">
				<label for="bairro">Bairro</label>
				<input class="form-control" placeholder="Digite o bairro" type="text" name="bairro" id="bairro" maxlength="100" size="60" value="<?php echo $bairro; ?>">
				<div id="div_erro_bairro"></div>   
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="cep">Cep</label>
						<input class="form-control" placeholder="Digite o cep" type="text" name="cep" id="cep" maxlength="8" size="15" value="<?php echo $cep; ?>">
						<div id="div_erro_cep"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="cod_cidade">Cidade</label>
						<select class="form-control" name="cod_cidade" id="cod_cidade">
							<option value=''>Selecione a sua cidade</option>
							<?php
							$r = $pdo->query("select * from cidades order by nome");		
							while($d = $r->fetch(PDO::FETCH_ASSOC)) 
							{
								$s = $d['cod_cidade'] == $cod_cidade ? ' selected="selected" ' : '';
								echo "<option value='$d[cod_cidade]'  $s > $d[nome] - $d[uf] </option>";
							}
							?>
						</select>
						<div id="div_erro_cod_cidade"></div>
					</div>
				</div>
			</div>
			<p></p>

			<div id="div_erro_geral"></div>

			<p></p>

			<input class="btn btn-success" type="submit" name="btenvio" id="btenvio" value=" Gravar ">

			<input class="btn btn-danger" type="button" name="btcancelar" id="btcancelar" 
			value=" Cancelar " onclick="document.location='index.php?modulo=fornecedores';">
			<p></p>
		</form>
	</div>
</div>