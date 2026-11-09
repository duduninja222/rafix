<?php
// Conexão central (PDO). Ajuste usuário/senha se necessário.
session_start();
const NOME_LOJA = 'Mercado Boa Compra';
try {
    $pdo = new PDO('mysql:host=localhost;dbname=supermercado;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $ex) {
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Verifique se o MySQL do XAMPP está ligado.');
}
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function reais($v) { return 'R$ ' . number_format((float)$v, 2, ',', '.'); }
function flash($tipo, $msg) { $_SESSION['flash'] = [$tipo, $msg]; }
function ir($url) { header("Location: $url"); exit; }
function id_get() { $i = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); return ($i && $i > 0) ? $i : null; }
function nao_encontrado($msg, $volta) {
    global $titulo; $titulo = 'Não encontrado';
    include __DIR__ . '/header.php';
    echo '<p class="msg erro">' . e($msg) . '</p><a class="btn" href="' . e($volta) . '">Voltar</a>';
    include __DIR__ . '/footer.php'; exit;
}
