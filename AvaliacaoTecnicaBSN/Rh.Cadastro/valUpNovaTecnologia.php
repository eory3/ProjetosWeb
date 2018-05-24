<?php

   require_once('conexao.php'); //importando banco
 
   $result =0; 
 
   //recebendo atributos
   $id = trim($_POST['id']);
   
   $nome = trim($_POST['nome']);
   
   $vaga = trim($_POST['vaga']);
   
   
    //atualizando banco
    $stmt = $pdo->prepare("UPDATE novaTecnologia 
    set nome = :nome, vaga = :vaga
    where idTecnologia = :id");
    
    //atribuindo valores para os apelidos
    $stmt->bindParam(':nome', $nome);
    
    $stmt->bindParam(':vaga', $vaga);
    
    $stmt->bindParam(':id', $id);
   
    
   if($stmt->execute()){
    
      $result =1;

    }

    echo $result;

    $pdo = null;
   header("Location: index.php"); //recarregando pagina inicial
?>