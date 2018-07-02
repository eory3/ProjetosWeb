<script type="text/javascript">

// exclui um registro --------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir essa cidade ??') )
	{
		document.location='cidades_gravar.php?acao=excluir&cod_cidade='+codigo;
	}
}


//-Quando a página estiver totalmente carregada --------
$(document).ready( function(){ 

	// colocando o foco na caixa de edição da pesquisa 
	$('#txtPesquisa').focus();
	$('#txtPesquisa').select();
    
}); // ready

</script>

<h2>CADASTRO DE CIDADES</h2>

<form name="fpesq" id="fpesq" method="post" action="">

<?php
	$pesquisa = @$_POST['txtPesquisa'];
?>

Pesquisa:
<input type="text" name="txtPesquisa" id="txtPesquisa" size="40" value="<?php echo $pesquisa; ?>">

<input type="submit" name="btenviar" id="btenviar" value="Pesquisar">

</form>



<?php

	// se a variável $_GET['msg'] existir
	if( isset($_GET['msg']) )
	{
		echo '<p style="color:#f00;">' . $_GET['msg'] . '</p>';
	}

	$sql = " select * 
			 from cidades 
			 where nome like '%$pesquisa%'
			 		or uf = '$pesquisa'
			 order by nome";

	$r = $pdo->query($sql);

	if( !$r ) die('Problemas..., tente mais tarde !');


	echo '<a href="index.php?modulo=cidades_ficha&acao=incluir">Incluir</a>';

	echo '<table width="98%" cellpading="5">';
	echo '<tr bgcolor="#ccc">';
	echo ' <td width="10%">Código</td>';
	echo ' <td width="60%">Nome</td>';
	echo ' <td width="30%">Opções</td>';
	echo '</tr>';

	// obtendo o próximo registro da consulta
	while( $dados = $r->fetch(PDO::FETCH_ASSOC) )
	{
		echo '<tr  bgcolor="#efefef">';
		echo ' <td>'.$dados['cod_cidade'].'</td>';
		echo ' <td>'.$dados['nome'] . '-' . $dados['uf'].'</td>';

		echo ' <td>';
		
		echo '<a href="index.php?modulo=cidades_ficha&acao=alterar&cod_cidade='.$dados['cod_cidade'].'">Alterar</a>';
		
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';

		//echo '<a href="cidades_gravar.php?acao=excluir&cod_cidade='.$dados['cod_cidade'].'">Excluir</a>';

		echo '<a href="javascript:excluir('.$dados['cod_cidade'].');">Excluir</a>';

		echo '</td>';

		echo '</tr>';
	} // while

	echo '</table>';


?>

