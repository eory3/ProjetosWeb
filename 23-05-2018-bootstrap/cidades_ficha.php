<script type="text/javascript">
	
//----------------------------------	
$(document).ready(function(){

	$('div[id*=div_erro]').css('color','#f00');

	// capturando o evento submit do formulário
	$('#fcad').submit(function(){
		
		$('div[id*=div_erro]').html('');

		erros=0;

		if( $.trim($('#nome').val()) == '' )
		{
			$('#div_erro_nome').html('O nome deve ser preenchido!');
			erros++;
		}

		if( $.trim($('#uf').val()) == '' )
		{
			$('#div_erro_uf').html('A uf deve ser preenchida!');
			erros++;
		}

		return erros == 0;

	}); // evendo submit do formulário fcad

}); // ready

</script>

<?php

	$cod_cidade = @$_GET['cod_cidade'];
	$acao = @$_GET['acao'];

	$nome = '';
	$uf   = '';

	if( $acao == 'alterar' )
	{
		$sql = " select * from cidades where cod_cidade = '$cod_cidade'";
		$r = $pdo->query($sql);		
		if( $d = $r->fetch(PDO::FETCH_ASSOC))
		{
			$nome  = $d['nome'];
			$uf    = $d['uf'];
		}
		else 
		{
			header('Location: cidades.php?msg=Cidade não encontrada!');
		}
	}


?>


<h2>CADASTRO DE CIDADES : FICHA</h2>

<form  name="fcad" id="fcad" method="POST" action="cidades_gravar.php?acao=<?php echo $acao; ?>&cod_cidade=<?php echo $cod_cidade; ?>">

Nome:<br>
<input type="text" name="nome" id="nome" maxlength="100" 
   size="60" value="<?php echo $nome; ?>">
<div id="div_erro_nome"></div>

<p></p>

Unidade Federal:<br>
<input type="text" name="uf" id="uf" maxlength="2" 
   size="10" value="<?php echo $uf; ?>">
<div id="div_erro_uf"></div>

<p></p>

<input type="submit" name="btenvio" id="btenvio" 
   value=" Gravar ">

<input type="button" name="btcancelar" id="btcancelar" 
   value=" Cancelar " onclick="document.location='index.php?modulo=cidades';">

</form>

