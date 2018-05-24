<?php
include_once "conexao.php";  //importando banco

try{
	//recebendo atributos
	$nome = $_POST['nome'];
	$vaga = isset($_POST['vaga'])?$_POST['vaga']:0;

	//inserindo no banco
	$stmt = $pdo->prepare("insert into novaTecnologia (nome, vaga) values ('".$nome."',".$vaga.")");
	
	//atribuindo valores oas apelidos
	$stmt->execute(array(
		':nome'=>$nome,
		':vaga'=>$vaga
	));

	if($stmt->rowCount() != 0){
		header("Location: index.php"); //recarregando pagina inicial
	}
}catch(Exception $e){
	echo "Erro $e";
}
?>
