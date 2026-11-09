<?php
require 'includes/conexao.php';
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
$id = $post ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) : id_get();
if (!$id) nao_encontrado('Identificador inválido.', 'produtos.php');
$st = $pdo->prepare('SELECT id,codigo,nome FROM produtos WHERE id=?'); $st->execute([$id]); $p = $st->fetch();
if (!$p) nao_encontrado('Produto não encontrado.', 'produtos.php');
if ($post) {
    try { $pdo->prepare('DELETE FROM produtos WHERE id=?')->execute([$id]); flash('ok', 'Produto excluído.'); }
    catch (PDOException $ex) { flash('erro', 'Não foi possível excluir o produto.'); }
    ir('produtos.php');
}
$titulo = 'Excluir produto'; include 'includes/header.php'; ?>
<h1>Excluir produto</h1>
<div class="card"><p>Produto: <strong><?= e($p['codigo']) ?> - <?= e($p['nome']) ?></strong></p>
<p>Tem certeza que deseja excluir? Esta ação não pode ser desfeita.</p>
<form method="post" action="produto_excluir.php"><input type="hidden" name="id" value="<?= (int)$id ?>">
<button class="btn perigo" type="submit">Sim, excluir</button> <a class="btn sec" href="produtos.php">Cancelar</a></form></div>
<?php include 'includes/footer.php'; ?>
