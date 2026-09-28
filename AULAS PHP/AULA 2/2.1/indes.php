<?php

$quantidade = $_POST ["quantidade"];

$preco = $_POST ["preco"];

$total = $quantidade * $preco;

echo "<h1>Resultado da Compra</h1>";

echo "Quantidade de produtos: " . $quantidade . "<br>";

echo "Preco por item: R$ " . number_format($preco, 2, ',', '.') . "<br>";

echo "Total: R$ " . number_format($total, 2, ',', '.');
?>