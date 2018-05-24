<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Maior sequencia de um número entre 1 e 1 milhão</title>
</head>
<body>
<?php
    $maiorSequencia = 0;
    $sequencia = 1;
    $valor = 0;
    $n = 1000000;
    $var = $n;
    while($n > 1){
        while($var > 1){
            if($var % 2 == 0){//se for par
                $var = ($var / 2);
            }
            else{//se for impar
                $var = ((3 * $var) + 1);
            }
            $sequencia++;//contando o tamanho da sequencia
        }
        if($sequencia > $maiorSequencia){//verificando se é maior sequencia para atribuir valores
            $maiorSequencia = $sequencia;
            $valor = $n;
        }
        $sequencia = 1;//reiniciando contador de sequencia
        $var = --$n;
    }
    echo "O número entre 1 e 1 milhão que tem a maior sequencia é o número $valor";
?>
</body>
</html>