<section>
    <h2>Editar Seleção</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?controller=Selecoes&action=update">
        <input type="hidden" name="id" value="<?= (int)$selecao['id'] ?>">
        <label>Nome
            <input type="text" name="nome" value="<?= htmlspecialchars($selecao['nome']) ?>" required>
        </label>
        <label>Continente
            <input type="text" name="continente" value="<?= htmlspecialchars($selecao['continente']) ?>" required>
        </label>
        <label>Grupo
            <select name="grupo_id" required>
                <?php foreach ($grupos as $g): ?>
                    <option value="<?= (int)$g['id'] ?>" <?= ((int)$selecao['grupo_id']===(int)$g['id'])?'selected':'' ?>>
                        <?= htmlspecialchars($g['letra']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn" type="submit">Salvar</button>
        <a class="btn" href="index.php?controller=Selecoes&action=index">Voltar</a>
    </form>
</section>

