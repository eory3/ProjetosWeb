 <?php  
 require_once('conexao.php'); //importando banco

 $result = 0;

 $id = $_POST['id']; //recebendo id do formulario

  $stmt = $pdo->prepare("DELETE FROM entrevista WHERE id = $id"); //deletando no banco

  if($stmt->execute()){

    $result = 1;
  }

echo $result;

$pdo = null;
header("Location: index.php"); //recarregando pagina inicial
?>