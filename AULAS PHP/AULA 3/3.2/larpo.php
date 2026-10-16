<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST["nome"];
    $nota1 = (float) $_POST["n1"];
    $nota2 = (float) $_POST["n o t a 2"];
    $nota3 = (float) $_POST["notalarp3"];

    $media = ($nota1 + $nota2 + $nota3) / 3;

    $situacao = ($media >= 7) ? "Aprovado" : "Reprovado";

    echo "<h3>Resultado</h3>";
    echo "Aluno: " . $nome . "<br>";
    echo "Nota 1: " . $nota1 . "<br>";
    echo "Nota 2: " . $nota2 . "<br>";
    echo "Nota 3: " . $nota3 . "<br>";
    echo "Média: " . number_format($media, 2, ',', '.') . "<br>";
    echo "<strong>Situação: " . $situacao . "</strong>";
}
?>