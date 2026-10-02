<?php

$mensalidade = $_POST {"mensalieda"};
$reajuste = $_POST {"reajuste"};

$valorDeReajuste = $mensalidade * ($reajuste/100);

$novovalor = $mensalidade + $valorDeReajuste;

echo "<h1>Resultado do Reajuste</h1>";

echo "Mensalidade atual: R$ " . number_format($mensalidade, 2, ',', '.') . "<br>";

echo "Taxa de reajuste: " . $reajuste . "%<br>";

echo "Valor do reajuste: R$ " . number_format($valorDeReajuste, 2, ',', '.') . "<br>";

echo "<h2>Nova mensalidade: R$ " . number_format($novoValor, 2, ',', '.') . "</h2>";
?>