<?php
// Fitness Manager - processamento da matrícula (sem banco de dados)

// Planos e preços fixos (para alterar um preço, mude apenas aqui)
$planos = [
    "basico"  => ["nome" => "Básico",  "preco" => 89.90],
    "plus"    => ["nome" => "Plus",    "preco" => 129.90],
    "premium" => ["nome" => "Premium", "preco" => 179.90],
];

// Percentuais de desconto (para alterar, mude apenas aqui)
$descontoPix   = 10;
$descontoIdoso = 15;

// Só aceita acesso via formulário (POST)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastro.html");
    exit;
}

// Recebe e limpa os dados
$nome      = trim($_POST["nome"] ?? "");
$telefone  = trim($_POST["telefone"] ?? "");
$email     = trim($_POST["email"] ?? "");
$idade     = trim($_POST["idade"] ?? "");
$data      = trim($_POST["data"] ?? "");
$plano     = $_POST["plano"] ?? "";
$pagamento = $_POST["pagamento"] ?? "";

// Validação
$erros = [];

if ($nome === "" || $telefone === "" || $email === "" || $idade === "" || $data === "" || $plano === "" || $pagamento === "") {
    $erros[] = "Preencha todos os campos.";
}
if ($idade !== "" && (!ctype_digit($idade) || (int)$idade < 18)) {
    $erros[] = "A idade deve ser um número inteiro igual ou maior que 18.";
}
if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "E-mail inválido.";
}
if ($telefone !== "" && !preg_match('/^[0-9()\s\-+]{8,20}$/', $telefone)) {
    $erros[] = "Telefone inválido.";
}
$dataObj = DateTime::createFromFormat("Y-m-d", $data);
if ($data !== "" && (!$dataObj || $dataObj->format("Y-m-d") !== $data)) {
    $erros[] = "Data da matrícula inválida.";
}
if ($plano !== "" && !isset($planos[$plano])) {
    $erros[] = "Plano inválido.";
}
if ($pagamento !== "" && !in_array($pagamento, ["pix", "cartao"], true)) {
    $erros[] = "Forma de pagamento inválida.";
}

$h = fn($t) => htmlspecialchars($t, ENT_QUOTES, "UTF-8");

// Cabeçalho comum da página
echo '<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<title>Comprovante - Fitness Manager</title><link rel="stylesheet" href="style.css"></head><body>';
echo '<header><h1>FITNESS MANAGER</h1><nav><a href="index.html">Painel</a><a href="cadastro.html">Matrículas</a><a href="planos.html">Planos</a></nav></header><main>';

if (!empty($erros)) {
    echo '<div class="msg erro">Não foi possível processar a matrícula</div>';
    echo '<ul class="erros">';
    foreach ($erros as $erro) {
        echo "<li>" . $h($erro) . "</li>";
    }
    echo "</ul>";
    echo '<a class="btn sec" href="javascript:history.back()">Voltar ao formulário</a>';
} else {
    $idade = (int)$idade;
    $precoOriginal = $planos[$plano]["preco"];

    // Regra de desconto: não acumula, vale o maior percentual
    $percentual = 0;
    if ($pagamento === "pix") {
        $percentual = $descontoPix;
    }
    if ($idade >= 60) {
        $percentual = max($percentual, $descontoIdoso);
    }

    $valorFinal = $precoOriginal - ($precoOriginal * $percentual / 100);
    $formaPag   = ($pagamento === "pix") ? "PIX" : "Cartão";
    $moeda      = fn($v) => "R$ " . number_format($v, 2, ",", ".");

    echo '<div class="msg ok">Matrícula processada com sucesso</div>';
    echo "<h2>Resumo da matrícula</h2>";
    echo "<table>";
    echo "<tr><td>Aluno</td><td>" . $h($nome) . "</td></tr>";
    echo "<tr><td>Idade</td><td>" . $idade . " anos</td></tr>";
    echo "<tr><td>Telefone</td><td>" . $h($telefone) . "</td></tr>";
    echo "<tr><td>E-mail</td><td>" . $h($email) . "</td></tr>";
    echo "<tr><td>Data da matrícula</td><td>" . $dataObj->format("d/m/Y") . "</td></tr>";
    echo "<tr><td>Plano</td><td>" . $planos[$plano]["nome"] . "</td></tr>";
    echo "<tr><td>Valor original</td><td>" . $moeda($precoOriginal) . "</td></tr>";
    echo "<tr><td>Forma de pagamento</td><td>" . $formaPag . "</td></tr>";
    echo "<tr><td>Desconto</td><td>" . $percentual . "%</td></tr>";
    echo "<tr><td>Valor final</td><td>" . $moeda($valorFinal) . "</td></tr>";
    echo "</table>";
    echo "<p><small>Exemplo ilustrativo: sem gravação permanente dos dados.</small></p>";
    echo '<a class="btn" href="cadastro.html">Nova matrícula</a>';
}

echo "</main></body></html>";