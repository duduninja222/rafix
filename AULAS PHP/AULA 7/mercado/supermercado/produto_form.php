<?php
require 'includes/conexao.php';
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
$id = $post ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) : id_get();
$cats = $pdo->query('SELECT id,nome FROM categorias ORDER BY nome')->fetchAll();
$d = ['codigo'=>'','nome'=>'','descricao'=>'','categoria_id'=>'','preco'=>'','estoque'=>'0','estoque_minimo'=>'0','validade'=>'']; $erros = [];
if (isset($_GET['id']) || isset($_POST['id'])) {
    $st = $pdo->prepare('SELECT * FROM produtos WHERE id=?'); $st->execute([(int)$id]); $reg = $st->fetch();
    if (!$reg) nao_encontrado('Produto não encontrado.', 'produtos.php');
    $d = $reg; $d['preco'] = number_format($reg['preco'], 2, ',', '');
}
if ($post) {
    foreach (array_keys($d) as $c) $d[$c] = trim($_POST[$c] ?? '');
    if ($d['codigo'] === '' || mb_strlen($d['codigo']) > 30) $erros[] = 'Código é obrigatório (até 30 caracteres).';
    if ($d['nome'] === '' || mb_strlen($d['nome']) > 120) $erros[] = 'Nome é obrigatório (até 120 caracteres).';
    $p = str_replace(',', '.', $d['preco']);
    if (!is_numeric($p) || (float)$p <= 0 || (float)$p >= 1e8) $erros[] = 'Preço deve ser numérico e maior que zero.';
    foreach (['estoque' => 'Estoque', 'estoque_minimo' => 'Estoque mínimo'] as $c => $r)
        if (filter_var($d[$c], FILTER_VALIDATE_INT) === false || (int)$d[$c] < 0) $erros[] = "$r deve ser um número inteiro maior ou igual a zero.";
    $catId = filter_var($d['categoria_id'], FILTER_VALIDATE_INT);
    $st = $pdo->prepare('SELECT 1 FROM categorias WHERE id=?'); $st->execute([(int)$catId]);
    if (!$catId || !$st->fetch()) $erros[] = 'Selecione uma categoria válida.';
    if ($d['validade'] !== '') {
        $dt = DateTime::createFromFormat('Y-m-d', $d['validade']);
        if (!$dt || $dt->format('Y-m-d') !== $d['validade']) $erros[] = 'Data de validade inválida.';
    }
    if ($d['codigo'] !== '') {
        $st = $pdo->prepare('SELECT 1 FROM produtos WHERE codigo=? AND id<>?'); $st->execute([$d['codigo'], (int)$id]);
        if ($st->fetch()) $erros[] = 'Já existe um produto com esse código.';
    }
    if (!$erros) {
        try {
            $val = $d['validade'] === '' ? null : $d['validade']; $desc = $d['descricao'] === '' ? null : $d['descricao'];
            $v = [$d['codigo'], $d['nome'], $desc, $catId, number_format((float)$p, 2, '.', ''), (int)$d['estoque'], (int)$d['estoque_minimo'], $val];
            if ($id) { $v[] = $id; $pdo->prepare('UPDATE produtos SET codigo=?,nome=?,descricao=?,categoria_id=?,preco=?,estoque=?,estoque_minimo=?,validade=? WHERE id=?')->execute($v); }
            else $pdo->prepare('INSERT INTO produtos (codigo,nome,descricao,categoria_id,preco,estoque,estoque_minimo,validade) VALUES (?,?,?,?,?,?,?,?)')->execute($v);
            if ($val && $val < date('Y-m-d')) flash('aviso', 'Produto salvo, mas a validade já passou: produto vencido.');
            else flash('ok', 'Produto salvo com sucesso.');
            ir('produtos.php');
        } catch (PDOException $ex) { $erros[] = 'Erro ao salvar. Tente novamente.'; }
    }
}
$titulo = $id ? 'Editar produto' : 'Novo produto'; include 'includes/header.php'; ?>
<h1><?= e($titulo) ?></h1>
<?php foreach ($erros as $er): ?><p class="msg erro"><?= e($er) ?></p><?php endforeach; ?>
<form class="card" method="post" action="produto_form.php"><input type="hidden" name="id" value="<?= e($id) ?>">
<label for="codigo">Código *</label><input id="codigo" name="codigo" maxlength="30" value="<?= e($d['codigo']) ?>" required>
<label for="nome">Nome *</label><input id="nome" name="nome" maxlength="120" value="<?= e($d['nome']) ?>" required>
<label for="categoria_id">Categoria *</label><select id="categoria_id" name="categoria_id" required><option value="">Selecione...</option>
<?php foreach ($cats as $c): ?><option value="<?= (int)$c['id'] ?>" <?= $d['categoria_id'] == $c['id'] ? 'selected' : '' ?>><?= e($c['nome']) ?></option><?php endforeach; ?></select>
<label for="preco">Preço (R$) *</label><input id="preco" name="preco" inputmode="decimal" value="<?= e($d['preco']) ?>" required>
<label for="estoque">Estoque *</label><input id="estoque" type="number" min="0" step="1" name="estoque" value="<?= e($d['estoque']) ?>" required>
<label for="estoque_minimo">Estoque mínimo *</label><input id="estoque_minimo" type="number" min="0" step="1" name="estoque_minimo" value="<?= e($d['estoque_minimo']) ?>" required>
<label for="validade">Validade</label><input id="validade" type="date" name="validade" value="<?= e($d['validade']) ?>">
<label for="descricao">Descrição</label><textarea id="descricao" name="descricao" rows="3"><?= e($d['descricao']) ?></textarea>
<p><button class="btn" type="submit">Salvar</button> <a class="btn sec" href="produtos.php">Cancelar</a></p>
</form><?php include 'includes/footer.php'; ?>
