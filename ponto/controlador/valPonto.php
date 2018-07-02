<?php 
include_once "../controlador/conexao.php"; //importando banco

try {
	//recebendo atributos
	$data = $_POST['dataPonto'];
	$tempo = $_POST['tempoPonto'];
	$valor;

	if ($tempo === "Meio Dia") {
		$valor = 25.0;
	}
	else{
		$valor = 50.0;
	}

	//inserindo no banco
	$stmt = $pdo->prepare("insert into horas (data, tempo, valor) values (:data,:tempo,:valor)");
	
	//atribuindo valores aos apelidos
	$stmt->execute(array(
		':data'=>$data,
		':tempo'=>$tempo,
		':valor'=>$valor
	));

	if($stmt->rowCount() != 0){
		header("Location: ../index.php"); //recarregando pagina inicial
	}
} catch (PDOException $e) {
	echo "Erro $e";
}
?>