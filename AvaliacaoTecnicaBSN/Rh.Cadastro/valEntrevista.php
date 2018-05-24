<?php 
include_once "conexao.php"; //importando banco

try {
	//recebendo atributos
	$nome = $_POST['nomeEntrevista'];
	$idade = $_POST['idadeEntrevista'];
	$sexo = $_POST['sexoEntrevista'];
	$cTecnologia = $_POST['tecnologiaEntrevista'];

	//inserindo no banco
	$stmt = $pdo->prepare("insert into entrevista (nome, idade, sexo, tecnologia) values ('".$nome."',".$idade.",'".$sexo."','".$cTecnologia."')");
	
	//atribuindo valores aos apelidos
	$stmt->execute(array(
		':nome'=>$nome,
		':idade'=>$idade,
		':sexo'=>$sexo,
		':tecnologia'=>$cTecnologia
	));

	if($stmt->rowCount() != 0){
		header("Location: index.php"); //recarregando pagina inicial
	}
} catch (PDOException $e) {
	echo "Erro $e";
}
?>