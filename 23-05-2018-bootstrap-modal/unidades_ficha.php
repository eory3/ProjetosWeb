<script type="text/javascript">
	
//----------------------------------	
$(document).ready(function(){

	$('div[id*=div_erro]').css('color','#f00');

	// capturando o evento submit do formulário
	$('#fcad').submit(function(){
		
		$('div[id*=div_erro]').html('');

		erros=0;

		if( $.trim($('#descricao').val()) == '' )
		{
			$('#div_erro_descricao').html('O descricao deve ser preenchida!');
			erros++;
		}

		return erros == 0;

	}); // evendo submit do formulário fcad

}); // ready

</script>

<?php

	$cod_unidade = @$_GET['cod_unidade'];
	$acao = @$_GET['acao'];

	$descricao = '';

	if( $acao == 'alterar' )
	{
		$sql = " select * from unidades where cod_unidade = '$cod_unidade'";
		$r = $pdo->query($sql);		
		if( $d = $r->fetch(PDO::FETCH_ASSOC))
		{
			$descricao  = $d['descricao'];
		}
		else 
		{
			header('Location: unidades.php?msg=Unidade não encontrada!');
		}
	}


?>

<div class="container">
	<div class="page-header">
		<h1>Cadastro de Unidade <small>Ficha</small></h1>
	</div>
	<div class="col-md-12">
		<form  name="fcad" id="fcad" method="POST" action="unidades_gravar.php?acao=<?php echo $acao; ?>&cod_unidade=<?php echo $cod_unidade; ?>">

		<div class="form-group">
			<label for="descricao">Descrição</label>
			<input type="text" name="descricao" id="descricao" class="form-control" placeholder="Digite a descrição da unidade" maxlength="100" 
		   		size="60" value="<?php echo $descricao; ?>">
			<div id="div_erro_descricao"></div>
		</div>

		<input type="submit" class="btn btn-success" name="btenvio" id="btenvio" 
		   value=" Gravar ">

		<input type="button" class="btn btn-danger" name="btcancelar" id="btcancelar" 
		   value=" Cancelar " onclick="document.location='index.php?modulo=unidades';">

		</form>
	</div>
</div>


