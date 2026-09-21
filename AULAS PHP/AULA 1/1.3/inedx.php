<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <H1>Calculo do IMC </H1>

    <?php
    $peso = 70;
    $altura = 1.75;
    
    $imc = $peso / ($altura * $altura);
    
    echo "Seu IMC é: " . $imc;
    ?>

</body>
</html>