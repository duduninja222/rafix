<?php
require 'includes/conexao.php';
$id = id_get(); if (!$id) nao_encontrado('Identificador inválido.', 'produtos.php');
$st = $pdo->prepare('SELECT p.*, c.nome AS categoria FROM produtos p JOIN categorias c ON c.id=p.categoria_id WHERE p.id=?');
$st->execute([$id]); $p = $st->fetch();
if (!$p) nao_encontrado('Produto não encontrado.', 'produtos.php');
$titulo = 'Detalhes do produto'; include 'includes/header.php'; ?>
<h1><?= e($p['nome']) ?></h1>
<?php if ($p['validade'] && $p['validade'] < date('Y-m-d')): ?><p class="msg aviso">Atenção: produto vencido.</p><?php endif; ?>
<?php if ($p['estoque'] <= $p['estoque_minimo']): ?><p class="msg aviso">Estoque abaixo ou igual ao mínimo.</p><?php endif; ?>
<div class="card">
<p><strong>Código:</strong> <?= e($p['codigo']) ?></p><p><strong>Categoria:</strong> <?= e($p['categoria']) ?></p>
<p><strong>Preço:</strong> <?= reais($p['preco']) ?></p><p><strong>Estoque:</strong> <?= (int)$p['estoque'] ?></p>
<p><strong>Estoque mínimo:</strong> <?= (int)$p['estoque_minimo'] ?></p>
<p><strong>Validade:</strong> <?= $p['validade'] ? e(date('d/m/Y', strtotime($p['validade']))) : 'Não informada' ?></p>
<p><strong>Descrição:</strong> <?= e($p['descricao']) ?></p></div>
<a class="btn sec" href="produtos.php">Voltar à lista</a> <a class="btn" href="produto_form.php?id=<?= (int)$p['id'] ?>">Editar</a>
<?php include 'includes/footer.php'; ?>
