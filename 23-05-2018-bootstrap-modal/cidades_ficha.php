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

<div class="container">
	<div class="page-header">
		<h1>Cadastro de Cidade <small>Ficha</small></h1>
	</div>
	<div class="col-md-12">
		<form  name="fcad" id="fcad" method="POST" action="cidades_gravar.php?acao=<?php echo $acao; ?>&cod_cidade=<?php echo $cod_cidade; ?>">

		<div class="form-group">
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome da cidade" maxlength="100" 
		   		size="60" value="<?php echo $nome; ?>">
			<div id="div_erro_nome"></div>
		</div>

		<div class="form-group">
			<label for="uf">Unidade Federal</label>
			<input type="text" name="uf" id="uf" maxlength="2" 
		   		size="2" class="form-control" placeholder="Digite a unidade federal" value="<?php echo $uf; ?>">
			<div id="div_erro_uf"></div>
		</div>

		<input type="submit" class="btn btn-success" name="btenvio" id="btenvio" 
		   value=" Gravar ">

		<input type="button" class="btn btn-danger" name="btcancelar" id="btcancelar" 
		   value=" Cancelar " onclick="document.location='index.php?modulo=cidades';">

		</form>
	</div>
</div>


