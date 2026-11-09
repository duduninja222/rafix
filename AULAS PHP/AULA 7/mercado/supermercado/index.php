<?php require 'includes/conexao.php'; $titulo = 'Início'; include 'includes/header.php'; ?>
<h1>Bem-vindo ao <?= e(NOME_LOJA) ?></h1>
<p>Painel administrativo de produtos e categorias.</p>
<div class="atalhos">
<a class="btn" href="produtos.php">📦 Produtos</a>
<a class="btn" href="categorias.php">🏷️ Categorias</a>
</div>
<?php include 'includes/footer.php'; ?>
