<?php
require 'includes/conexao.php';
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
$id = $post ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) : id_get();
$d = ['nome' => '', 'descricao' => '']; $erros = [];
if (isset($_GET['id']) || isset($_POST['id'])) {
    $st = $pdo->prepare('SELECT * FROM categorias WHERE id=?'); $st->execute([(int)$id]); $d = $st->fetch();
    if (!$d) nao_encontrado('Categoria não encontrada.', 'categorias.php');
}
if ($post) {
    $d['nome'] = trim($_POST['nome'] ?? ''); $d['descricao'] = trim($_POST['descricao'] ?? '');
    if ($d['nome'] === '' || mb_strlen($d['nome']) > 60) $erros[] = 'Nome é obrigatório (até 60 caracteres).';
    if (mb_strlen($d['descricao']) > 255) $erros[] = 'Descrição deve ter até 255 caracteres.';
    if (!$erros) {
        $st = $pdo->prepare('SELECT id FROM categorias WHERE nome=? AND id<>?'); $st->execute([$d['nome'], (int)$id]);
        if ($st->fetch()) $erros[] = 'Já existe uma categoria com esse nome.';
    }
    if (!$erros) {
        try {
            $desc = $d['descricao'] === '' ? null : $d['descricao'];
            if ($id) { $st = $pdo->prepare('UPDATE categorias SET nome=?, descricao=? WHERE id=?'); $st->execute([$d['nome'], $desc, $id]); }
            else { $st = $pdo->prepare('INSERT INTO categorias (nome,descricao) VALUES (?,?)'); $st->execute([$d['nome'], $desc]); }
            flash('ok', 'Categoria salva com sucesso.'); ir('categorias.php');
        } catch (PDOException $ex) { $erros[] = 'Erro ao salvar. Tente novamente.'; }
    }
}
$titulo = $id ? 'Editar categoria' : 'Nova categoria'; include 'includes/header.php'; ?>
<h1><?= e($titulo) ?></h1>
<?php foreach ($erros as $er): ?><p class="msg erro"><?= e($er) ?></p><?php endforeach; ?>
<form class="card" method="post" action="categoria_form.php">
<input type="hidden" name="id" value="<?= e($id) ?>">
<label for="nome">Nome *</label><input id="nome" name="nome" maxlength="60" value="<?= e($d['nome']) ?>" required>
<label for="descricao">Descrição</label><input id="descricao" name="descricao" maxlength="255" value="<?= e($d['descricao']) ?>">
<p><button class="btn" type="submit">Salvar</button> <a class="btn sec" href="categorias.php">Cancelar</a></p>
</form><?php include 'includes/footer.php'; ?>
