<?php
	$cod_cliente = @$_GET['cod_cliente'];
	$acao = @$_GET['acao'];

	$nome                    = '';
	$cpf   					 = '';
	$data_nascimento         = '';
	$renda_familiar          = '';
	$rg                      = '';
	$telefone                = '';
	$celular                 = '';
	$email                   = '';
	$rua                     = '';
	$bairro                  = '';
	$cod_cidade              = '';
	$cep                     = '';
	$conheceu_por_jornais    = '';
	$conheceu_por_internet   = '';
	$conheceu_por_outro      = '';
	$sexo                    = '';

	if( $acao == 'alterar' )
	{
		$sql = "select * from clientes where cod_cliente = '$cod_cliente'";
		$r = $pdo->query($sql);		
		if( $d = $r->fetch(PDO::FETCH_ASSOC))
		{
			$nome   		         = $d['nome'];
			$cpf    		         = $d['cpf'];
			$data_nascimento         = dataBR($d['data_nascimento']);
			$renda_familiar          = floatBR($d['renda_familiar']);
			$rg                      = $d['rg'];
			$telefone                = $d['telefone'];
			$celular                 = $d['celular'];
			$email                   = $d['email'];
			$rua                     = $d['rua'];
			$bairro                  = $d['bairro'];
			$cod_cidade              = $d['cod_cidade'];
			$cep                     = $d['cep'];
			$conheceu_por_jornais    = $d['conheceu_por_jornais'];
			$conheceu_por_internet   = $d['conheceu_por_internet'];
			$conheceu_por_outro      = $d['conheceu_por_outro'];
			$sexo                    = $d['sexo'];

		} // se encontrar o registro para edição 
		else 
		{
			header('Location: clientes.php?msg=cliente não encontrado!');
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
		if( $.trim($('#nome').val()) == "")
		{
			$('#div_erro_nome').html('O nome do cliente deve ser preenchido !');
			erros++;
		}

		if( !validaCPF($('#cpf').val()) )
		{
			$('#div_erro_cpf').html('CPF inválido !');
			erros++;
		}

		if( $.trim($('#rg').val()) == "")
		{
			$('#div_erro_rg').html('O rg do cliente deve ser preenchido !');
			erros++;
		}

		if( !verificaData($('#data_nascimento').val()) )
		{
			$('#div_erro_data_nascimento').html('A data de nascimento deve ser válida !');
			erros++;
		}

		// validando botões de radio
		if ( $('input:radio[name=sexo]:checked').length == 0)
		{
			$('#div_erro_sexo').html('O sexo deve ser informado !');
			erros++;
		}

		if( !ValidaEmail($('#email').val()) )
		{
			$('#div_erro_email').html('E-mail inválido !');
			erros++;
		}


		if( !numReal($('#renda_familiar').val()) )
		{
			$('#div_erro_renda_familiar').html('A renda familiar deve conter um número válido !');
			erros++;
		}

		if( $.trim($('#telefone').val()) == '' && $.trim($('#celular').val()) == '' ) 
		{
			$('#div_erro_telefone').html('Pelo menos um dos telefones deve ser preenchido !');
			$('#div_erro_celular').html(  $('#div_erro_telefone').html()  );
			erros++;
		}

		if( $.trim($('#rua').val()) == '' ) 
		{
			$('#div_erro_rua').html('O endereço deve ser informado !');
			erros++;
		}

		if( $.trim($('#bairro').val()) == '' ) 
		{
			$('#div_erro_bairro').html('O bairro deve ser informado !');
			erros++;
		}

		if( $.trim($('#cep').val()) == '' ) 
		{
			$('#div_erro_cep').html('O cep deve ser informado !');
			erros++;
		}

		if( $.trim($('#cod_cidade').val()) == '' ) 
		{
			$('#div_erro_cod_cidade').html('A cidade deve ser informada !');
			erros++;
		}

		// validando ckeckbox
		if ( $('input:checkbox[name*=conheceu_por]:checked').length == 0)
		{
			$('#div_erro_conheceu_por').html('Você deve selecionar pelo menos um meio de mídia pelo qual conheceu nossa empresa !');
			erros++;
		}

		if( erros > 0 ) {
			$('#div_erro_geral').html('Não foi possível gravar as informações, pois houve ' + erros + ' erro(s) !!!');
		}

		return erros == 0;

	}); // submit do fcad

}); // ready

</script>

<h2>CADASTRO DE CLIENTES : FICHA</h2>

<form  name="fcad" id="fcad" method="POST" action="clientes_gravar.php?acao=<?php echo $acao; ?>&cod_cliente=<?php echo $cod_cliente; ?>">

Nome:<br>
<input type="text" name="nome" id="nome" maxlength="100" size="60" value="<?php echo $nome; ?>">
<div id="div_erro_nome"></div>

CPF:<br>
<input type="text" name="cpf" id="cpf" maxlength="11" size="20" value="<?php echo $cpf; ?>">
<div id="div_erro_cpf"></div>   

RG:<br>
<input type="text" name="rg" id="rg" maxlength="16" size="20" value="<?php echo $rg; ?>">
<div id="div_erro_rg"></div>   

Data de Nascimento:<br>
<input type="text" name="data_nascimento" id="data_nascimento" maxlength="10" size="20" value="<?php echo $data_nascimento; ?>">
<div id="div_erro_data_nascimento"></div>   

Sexo:<br>
	<label>
		<input type="radio" name="sexo" id="sexoM" value="M"  
			<?php echo $sexo == 'M' ? ' checked="checked" ' : '' ?>  
		> Masculino
	</label>
	<label>
		<input type="radio" name="sexo" id="sexoF" value="F"  
			<?php echo $sexo == 'F' ? ' checked="checked" ' : '' ?>  
		> Feminino
	</label>	
<div id="div_erro_sexo"></div>   

Renda Familiar:<br>
<input type="text" name="renda_familiar" id="renda_familiar" size="20" value="<?php echo $renda_familiar; ?>">
<div id="div_erro_renda_familiar"></div>   

Telefone Fixo:<br>
<input type="text" name="telefone" id="telefone" maxlength="20" size="20" value="<?php echo $telefone; ?>">
<div id="div_erro_telefone"></div>   

Celular:<br>
<input type="text" name="celular" id="celular" maxlength="20" size="20" value="<?php echo $celular; ?>">
<div id="div_erro_celular"></div>   

E-mail:<br>
<input type="text" name="email" id="email" maxlength="150" size="70" value="<?php echo $email; ?>">
<div id="div_erro_email"></div>   

Logradouro (Rua/Avenida/Alameda):<br>
<input type="text" name="rua" id="rua" maxlength="200" size="70" value="<?php echo $rua; ?>">
<div id="div_erro_rua"></div>   

Bairro:<br>
<input type="text" name="bairro" id="bairro" maxlength="100" size="60" value="<?php echo $bairro; ?>">
<div id="div_erro_bairro"></div>   

Cep:<br>
<input type="text" name="cep" id="cep" maxlength="8" size="15" value="<?php echo $cep; ?>">
<div id="div_erro_cep"></div>   

Cidade:<br>
<select name="cod_cidade" id="cod_cidade">
	<option value=''>Selecione uma cidade</option>
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

Como conheceu nossa empresa ?<br>
	<label>
		<input type="checkbox" name="conheceu_por_jornais" id="conheceu_por_jornais" value="1"  
			<?php echo $conheceu_por_jornais == '1' ? ' checked="checked" ' : '' ?>  
		>Jornais
	</label>
	<label>
		<input type="checkbox" name="conheceu_por_internet" id="conheceu_por_internet" value="1"  
			<?php echo $conheceu_por_internet == '1' ? ' checked="checked" ' : '' ?>  
		>Internet
	</label>
	<label>
		<input type="checkbox" name="conheceu_por_outro" id="conheceu_por_outro" value="1"  
			<?php echo $conheceu_por_outro == '1' ? ' checked="checked" ' : '' ?>  
		>Outro
	</label>
<div id="div_erro_conheceu_por"></div>   

<p></p>

<div id="div_erro_geral"></div>

<p></p>

<input type="submit" name="btenvio" id="btenvio" value=" Gravar ">

<input type="button" name="btcancelar" id="btcancelar" 
   value=" Cancelar " onclick="document.location='index.php?modulo=clientes';">

</form>

