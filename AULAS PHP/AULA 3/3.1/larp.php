<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor1 = $_POST["valor1"];
    $valor2 = $_POST["valor2"];
    $valor3 = $_POST["valor3"];

    $soma = $valor1 + $valor2 + $valor3;

    echo "<h3>Resultado</h3>";
    echo "Valor 1: " . $valor1 . "<br>";
    echo "Valor 2: " . $valor2 . "<br>";
    echo "Valor 3: " . $valor3 . "<br>";
    echo "<strong>Soma: " . $soma . "</strong>";
}
?>
