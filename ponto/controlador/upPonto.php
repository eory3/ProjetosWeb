<?php

   require_once('conexao.php'); //importando o banco
 
   $result =0; 
    
   //recebendo atributos
   $id  = $_POST["id"];
   
   $data  = $_POST["dataPonto"];

   $tempo  = $_POST["tempoPonto"];

   $valor = 0;

	if ($tempo === "Meio Dia") {
		$valor = 25.0;
	}
	else{
		$valor = 50.0;
	}   
   
    //atualizando no banco
    $stmt = $pdo->prepare("UPDATE horas 
    set data = :data, tempo = :tempo , valor = :valor
    where id = :id");
    
    //valores para os apelidos
    $stmt->bindParam(':id', $id);

    $stmt->bindParam(':data', $data);
    
    $stmt->bindParam(':tempo', $tempo);
    
    $stmt->bindParam(':valor', $valor);

    
   if($stmt->execute()){
    
      $result =1;

    }

    echo $result;

    $pdo = null;
    header("Location: ../index.php"); //recarregando pagina inicial
?>