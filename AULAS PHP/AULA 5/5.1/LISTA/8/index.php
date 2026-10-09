<?php

$frutas1 = ["Maçã", "Banana", "Laranja"];
$frutas2 = ["Uva", "Manga", "Abacaxi"];

$frutas= array_merge[$frutas1, $frutas2];

echo implode("<br>", $frutas);

?>