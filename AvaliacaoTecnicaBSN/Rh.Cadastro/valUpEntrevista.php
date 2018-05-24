<?php

   require_once('conexao.php'); //importando o banco
 
   $result =0; 
    
   //recebendo atributos
   $id  = trim($_POST["id"]);
   
   $nome  = trim($_POST["nomeEntrevista"]);
   
   $idade    = trim($_POST["idadeEntrevista"]);
   
   $sexo = trim($_POST["sexoEntrevista"]);

   $tecnologia = trim($_POST["tecnologiaEntrevista"]);
   
    //atualizando no banco
    $stmt = $pdo->prepare("UPDATE entrevista 
    set nome = :nome, idade = :idade , sexo = :sexo, tecnologia = :tecnologia
    where id = :id");
    
    //valores para os apelidos
    $stmt->bindParam(':nome', $nome);
    
    $stmt->bindParam(':idade', $idade);
    
    $stmt->bindParam(':sexo', $sexo);

    $stmt->bindParam(':tecnologia', $tecnologia);
    
    $stmt->bindParam(':id', $id);
   
    
   if($stmt->execute()){
    
      $result =1;

    }

    echo $result;

    $pdo = null;
    header("Location: index.php"); //recarregando pagina inicial
?>