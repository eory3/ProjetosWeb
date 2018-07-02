
<script type="text/javascript">

// exclui um registro --------
function excluir(codigo)
{
	if( confirm('Deseja realmente excluir esse cliente ??') )
	{
		document.location='clientes_gravar.php?acao=excluir&cod_cliente='+codigo;
	}
}

<?php 
	include_once('bd.php');
	$pdo = new BD();
	$pdo = $pdo->conexao;
 ?>

//-Quando a página estiver totalmente carregada --------
$(document).ready( function(){ 

	// colocando o foco na caixa de edição da pesquisa 
	$('#txtPesquisa').focus();
	$('#txtPesquisa').select();
    
}); // ready

</script>

<h2>CADASTRO DE CLIENTES</h2>

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
			 from clientes 
			 where nome like '%$pesquisa%'
			 order by nome";

	// enviando um comando SQL para o banco de dados
	$r= $pdo->prepare($sql);
	$r->execute();

	if( !$r ) die('Problemas com o SQL !');

	echo '<p><a href="index.php?modulo=clientes_ficha&acao=incluir">Incluir</a></p>';

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
		echo ' <td>'.$dados['cod_cliente'].'</td>';
		echo ' <td>'.$dados['nome'] . '</td>';

		echo ' <td>';
		
		echo '<a href="index.php?modulo=clientes_ficha&acao=alterar&cod_cliente='.$dados['cod_cliente'].'">Alterar</a>';
		
		echo '&nbsp;&nbsp;&nbsp;&nbsp;';

		//echo '<a href="clientes_gravar.php?acao=excluir&cod_cliente='.$dados['cod_cliente'].'">Excluir</a>';

		echo '<a href="javascript:excluir('.$dados['cod_cliente'].');">Excluir</a>';

		echo '</td>';

		echo '</tr>';
	} // while

	echo '</table>';


?>

