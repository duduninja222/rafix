<?php

$peso = 70;
$altura = 1.75;

$imc = $peso / ($altura * $altura);

echo "Peso: $peso kg <br>";
echo "Altura: $altura m <br>";

echo "IMC: " . number_format($imc, 2, ',', '.');

?>