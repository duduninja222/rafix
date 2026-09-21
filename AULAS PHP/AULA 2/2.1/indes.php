<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $quantidade = $_POST["quantidade"];
    $valor = $_POST["valor"];

    $total = $quantidade * $valor;

    echo "<h2>Total: R$ " . number_format($total, 2, ',', '.') . "</h2>";
}
?>