<?php $titulo = $titulo ?? 'Início'; ?>
<!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($titulo) ?> - <?= e(NOME_LOJA) ?></title>
<link rel="stylesheet" href="css/style.css"></head><body>
<header><a class="logo" href="index.php">🛒 <?= e(NOME_LOJA) ?></a>
<nav><a href="index.php">Início</a><a href="produtos.php">Produtos</a><a href="categorias.php">Categorias</a></nav></header>
<main>
<?php if (!empty($_SESSION['flash'])): [$t, $m] = $_SESSION['flash']; unset($_SESSION['flash']); ?>
<p class="msg <?= e($t) ?>"><?= e($m) ?></p>
<?php endif; ?>
