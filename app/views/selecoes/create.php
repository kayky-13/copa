<section>
    <h2>Criar Seleção</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?controller=Selecoes&action=store">
        <label>Nome
            <input type="text" name="nome" required>
        </label>
        <label>Continente
            <input type="text" name="continente" required>
        </label>
        <label>Grupo
            <select name="grupo_id" required>
                <option value="">Selecione...</option>
                <?php foreach ($grupos as $g): ?>
                    <option value="<?= (int)$g['id'] ?>"><?= htmlspecialchars($g['letra']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn" type="submit">Salvar</button>
        <a class="btn" href="index.php?controller=Selecoes&action=index">Voltar</a>
    </form>
</section>

