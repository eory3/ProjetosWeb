<?php 
session_start();
require_once('conexao.php'); //importando banco

//fazendo busca no banco

$nTecnologia = $pdo->prepare("SELECT * FROM novaTecnologia");

$nTecnologia->execute();

$entrevista = $pdo->prepare("SELECT * FROM entrevista");

$entrevista->execute();

?>
<!DOCTYPE html>
<html>
<head>

    <!-- BootStrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
 
    <!-- jQuery --> 
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset= "utf8" src="js/jquery-3.3.1.min.js"></script>
 
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.min.js"></script>
    
    <!-- script das tabelas -->
    <script>
    $(document).ready(function(){
        $('#example1').DataTable( {
        columnDefs: [
            {
                targets: [ 0, 1, 2 ],
                className: 'mdl-data-table__cell--non-numeric'
            }
        ]
        } );
        $('#example2').DataTable( {
        columnDefs: [
            {
                targets: [ 0, 1, 2 ],
                className: 'mdl-data-table__cell--non-numeric'
            }
        ]
        } );
    });
    </script>    

    <meta charset="UTF-8">
    <title>Avaliação Tecnica BSN</title>
</head>
<body>

    <!-- menu-->
    <div class="container">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
            <a class="navbar-brand" href="index.php">Home</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="addNovaTecnologia.php">Cadastrar nova tecnologia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="addEntrevista.php">Entrevistar</a>
                </li>                
            </ul>
        </nav>

        <!-- div principal -->
        <div id="accordion" style="margin-top: 80px;">
            
            <!-- Tabela de tecnologias disponiveis e a quantidade de vagas -->
            <div class="card">
                <div class="card-header">
                    <a class="card-link" data-toggle="collapse" data-parent="#accordion" href="#tecnologiasCadastradas">
                        Tecnologias disponiveis
                    </a>
                </div>
                <div id="tecnologiasCadastradas" class="collapse show">
                    <div class="card-body">                     
                        <table id="example1" class="mdl-data-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DESCRIÇÃO</th>
                                <th>NUMERO DE VAGAS</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- atribuindo valores do banco na tabela -->
                            <?php if($nTecnologia->rowCount()): 
                            while($row = $nTecnologia->fetch(PDO::FETCH_ASSOC)){?>

                            <tr>
                                <td><?php echo $row['idTecnologia']; ?></td>
                                <td><?php echo $row['nome']; ?></td>
                                <td><?php echo $row['vaga']; ?></td>
                                <td>

                                    <!-- botoes -->
                                    <form method="POST" action="delNovaTecnologia.php">
                                        <button type="submit" name="id" value="<?php echo $row['idTecnologia']; ?>">Deletar</button>
                                    </form>  
                                    <form method="POST" action="upNovaTecnologia.php">
                                        <button type="submit" name="id" value="<?php echo $row['idTecnologia']; ?>">Editar</button>
                                    </form>                                                                      
                                </td>
                            </tr>
                            <?php } ?>
                        <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- Tabela de entrevistados -->
        <div class="card">
            <div class="card-header">
                <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#entrevistados">
                    Entrevistados
                </a>
            </div>
            <div id="entrevistados" class="collapse show">
                <div class="card-body">                     
                    <table id="example2" class="mdl-data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>IDADE</th>
                            <th>SEXO</th>
                            <th>TECNOLOGIA CADASTRADA</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- atribuindo valores do banco na tabela -->
                        <?php if($entrevista->rowCount()):
                        while($row = $entrevista->fetch(PDO::FETCH_ASSOC)){?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>  
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['idade']; ?></td>
                            <td><?php echo $row['sexo']; ?></td>
                            <td><?php echo $row['tecnologia']; ?></td>
                            <td>

                                <!-- botoes -->
                                <form method="POST" action="delEntrevista.php">
                                    <button type="submit" name="id" value="<?php echo $row['id']; ?>">Deletar</button>
                                </form>
                                <form method="POST" action="upEntrevista.php">
                                    <button type="submit" name="id" value="<?php echo $row['id']; ?>">Editar</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>