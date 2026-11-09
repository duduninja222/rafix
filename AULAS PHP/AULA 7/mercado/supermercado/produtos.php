<?php
require 'includes/conexao.php'; $titulo = 'Produtos';
$q = trim($_GET['q'] ?? ''); $cat = filter_input(INPUT_GET, 'categoria', FILTER_VALIDATE_INT);
$sql = 'SELECT p.*, c.nome AS categoria FROM produtos p JOIN categorias c ON c.id=p.categoria_id WHERE 1=1'; $par = [];
if ($q !== '') { $sql .= ' AND (p.nome LIKE ? OR p.codigo LIKE ?)'; $par[] = "%$q%"; $par[] = "%$q%"; }
if ($cat) { $sql .= ' AND p.categoria_id=?'; $par[] = $cat; }
$st = $pdo->prepare($sql . ' ORDER BY p.nome'); $st->execute($par); $lista = $st->fetchAll();
$cats = $pdo->query('SELECT id,nome FROM categorias ORDER BY nome')->fetchAll();
$hoje = date('Y-m-d');
include 'includes/header.php'; ?>
<h1>Produtos</h1><p><a class="btn" href="produto_form.php">+ Novo produto</a></p>
<form class="card filtros" method="get" action="produtos.php">
<div><label for="q">Buscar por nome ou código</label><input id="q" name="q" value="<?= e($q) ?>"></div>
<div><label for="categoria">Categoria</label><select id="categoria" name="categoria"><option value="">Todas</option>
<?php foreach ($cats as $c): ?><option value="<?= (int)$c['id'] ?>" <?= $cat == $c['id'] ? 'selected' : '' ?>><?= e($c['nome']) ?></option><?php endforeach; ?></select></div>
<div><button class="btn" type="submit">Filtrar</button> <a class="btn sec" href="produtos.php">Limpar filtros</a></div>
</form>
<?php if (!$lista): ?><p class="msg aviso">Nenhum produto encontrado.</p><?php else: ?>
<div class="tabela"><table><tr><th>Código</th><th>Nome</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr>
<?php foreach ($lista as $p): $baixo = $p['estoque'] <= $p['estoque_minimo']; $venc = $p['validade'] && $p['validade'] < $hoje; ?>
<tr class="<?= $baixo ? 'baixo' : '' ?>"><td><?= e($p['codigo']) ?></td>
<td><?= e($p['nome']) ?> <?= $venc ? '<span class="tag">Vencido</span>' : '' ?></td>
<td><?= e($p['categoria']) ?></td><td><?= reais($p['preco']) ?></td>
<td><?= (int)$p['estoque'] ?> <?= $baixo ? '<span class="tag amarela">Estoque baixo</span>' : '' ?></td>
<td class="acoes"><a class="btn sec" href="produto_detalhes.php?id=<?= (int)$p['id'] ?>">Detalhes</a>
<a class="btn" href="produto_form.php?id=<?= (int)$p['id'] ?>">Editar</a>
<a class="btn perigo" href="produto_excluir.php?id=<?= (int)$p['id'] ?>">Excluir</a></td></tr>
<?php endforeach; ?></table></div><?php endif; include 'includes/footer.php'; ?>
