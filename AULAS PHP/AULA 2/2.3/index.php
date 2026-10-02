<?php

$salario = $_POST["salario"];

// CALCULO DO INSS
$inss = 0;

if ($salario <= 1621) {
    $inss = $salario * 0.075;
} elseif ($salario <= 2902.84) {
    $inss = (1621 * 0.075) + (($salario - 1621) * 0.09);
} elseif ($salario <= 4354.27) {
    $inss = (1621 * 0.075) + (1281.84 * 0.09) + (($salario - 2902.84) * 0.12);
} elseif ($salario <= 8475.55) {
    $inss = (1621 * 0.075) + (1281.84 * 0.09) + (1451.43 * 0.12) + (($salario - 4354.27) * 0.14);
} else {
    $inss = (1621 * 0.075) + (1281.84 * 0.09) + (1451.43 * 0.12) + (4121.28 * 0.14);
}

// CALCULO DO IRRF

$baseIR = $salario - max($inss, 607.20);

$irrf = 0;

if ($baseIR <= 2428.80) {
    $irrf = 0;
} elseif ($baseIR <= 2826.65) {
    $irrf = ($baseIR * 0.075) - 182.16;
} elseif ($baseIR <= 3751.05) {
    $irrf = ($baseIR * 0.15) - 394.16;
} elseif ($baseIR <= 4664.68) {
    $irrf = ($baseIR * 0.225) - 675.49;
} else {
    $irrf = ($baseIR * 0.275) - 908.73;
}

// REDUCAO DO IRRF EM 2026

if ($salario <= 5000) {
    $irrf = max(0, $irrf - 312.89);
} elseif ($salario <= 7350) {
    $reducao = 978.62 - (0.133145 * $salario);
    $irrf = max(0, $irrf - $reducao);
}

$irrf = max(0, $irrf);

// CALCULO DO SALARIO LIQUIDO

$liquido = $salario - $inss - $irrf;

// RESULTADO

echo "<h1>Resultado do Salário</h1>";

echo "Salário Bruto: R$ " . number_format($salario, 2, ',', '.') . "<br>";

echo "Desconto INSS: R$ " . number_format($inss, 2, ',', '.') . "<br>";

echo "Desconto IRRF: R$ " . number_format($irrf, 2, ',', '.') . "<br>";

echo "<hr>";

echo "<h2>Salário Líquido: R$ " . number_format($liquido, 2, ',', '.') . "</h2>";

?>