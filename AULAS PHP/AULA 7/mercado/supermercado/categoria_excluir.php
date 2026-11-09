<?php
require 'includes/conexao.php';
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
$id = $post ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) : id_get();
if (!$id) nao_encontrado('Identificador inválido.', 'categorias.php');
$st = $pdo->prepare('SELECT c.*, (SELECT COUNT(*) FROM produtos WHERE categoria_id=c.id) AS total FROM categorias c WHERE c.id=?');
$st->execute([$id]); $c = $st->fetch();
if (!$c) nao_encontrado('Categoria não encontrada.', 'categorias.php');
if ($post) {
    if ($c['total'] > 0) { flash('erro', 'Não é possível excluir: a categoria ainda possui produtos vinculados.'); ir('categorias.php'); }
    try { $pdo->prepare('DELETE FROM categorias WHERE id=?')->execute([$id]); flash('ok', 'Categoria excluída.'); }
    catch (PDOException $ex) { flash('erro', 'Não foi possível excluir a categoria.'); }
    ir('categorias.php');
}
$titulo = 'Excluir categoria'; include 'includes/header.php'; ?>
<h1>Excluir categoria</h1>
<div class="card"><p>Categoria: <strong><?= e($c['nome']) ?></strong></p>
<?php if ($c['total'] > 0): ?>
<p class="msg erro">Esta categoria possui <?= (int)$c['total'] ?> produto(s) vinculado(s) e não pode ser excluída. Mova ou exclua os produtos antes.</p>
<a class="btn sec" href="categorias.php">Voltar</a>
<?php else: ?>
<p>Tem certeza que deseja excluir? Esta ação não pode ser desfeita.</p>
<form method="post" action="categoria_excluir.php"><input type="hidden" name="id" value="<?= (int)$id ?>">
<button class="btn perigo" type="submit">Sim, excluir</button> <a class="btn sec" href="categorias.php">Cancelar</a></form>
<?php endif; ?></div><?php include 'includes/footer.php'; ?>
