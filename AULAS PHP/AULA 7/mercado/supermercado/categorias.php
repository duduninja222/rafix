<?php
require 'includes/conexao.php'; $titulo = 'Categorias';
$cats = $pdo->query('SELECT c.*, COUNT(p.id) AS total FROM categorias c LEFT JOIN produtos p ON p.categoria_id=c.id GROUP BY c.id ORDER BY c.nome')->fetchAll();
include 'includes/header.php'; ?>
<h1>Categorias</h1><p><a class="btn" href="categoria_form.php">+ Nova categoria</a></p>
<?php if (!$cats): ?><p class="msg aviso">Nenhuma categoria cadastrada.</p><?php else: ?>
<div class="tabela"><table><tr><th>Nome</th><th>Descrição</th><th>Produtos</th><th>Ações</th></tr>
<?php foreach ($cats as $c): ?><tr>
<td><?= e($c['nome']) ?></td><td><?= e($c['descricao']) ?></td><td><?= (int)$c['total'] ?></td>
<td class="acoes"><a class="btn sec" href="produtos.php?categoria=<?= (int)$c['id'] ?>">Ver</a>
<a class="btn" href="categoria_form.php?id=<?= (int)$c['id'] ?>">Editar</a>
<a class="btn perigo" href="categoria_excluir.php?id=<?= (int)$c['id'] ?>">Excluir</a></td></tr>
<?php endforeach; ?></table></div><?php endif; include 'includes/footer.php'; ?>
