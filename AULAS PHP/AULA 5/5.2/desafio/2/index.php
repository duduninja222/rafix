<?php

$clientes = [

    "nome" => $_POST["nome"],
    "idade" => $_POST["idade"],
    "e-mail" => $_POST["email"],
    "telefone" => $_POST["telefone"],
    "endereco" => $_POST["endereco"]

];

echo "<h1>Dados do Cliente</h1>";
echo "Nome: " . $cliente["nome"] . "<br>";
echo "Idade: " . $cliente["idade"] . " anos<br>";
echo "E-mail: " . $cliente["email"] . "<br>";
echo "Telefone: " . $cliente["telefone"] . "<br>";
echo "Endereço: " . $cliente["endereco"];

?>