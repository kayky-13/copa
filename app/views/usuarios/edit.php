<section>
    <h2>Editar Usuário</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?controller=Usuarios&action=update">
        <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">
        <label>Nome
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </label>
        <label>Idade
            <input type="number" name="idade" min="1" value="<?= (int)$usuario['idade'] ?>" required>
        </label>
        <label>Cargo
            <select name="cargo" required>
                <?php foreach (['jogador','técnico','árbitro','outros'] as $c): ?>
                <option value="<?= $c ?>" <?= ($usuario['cargo']===$c)?'selected':'' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Seleção
            <select name="selecao_id" required>
                <?php foreach ($selecoes as $s): ?>
                    <option value="<?= (int)$s['id'] ?>" <?= ((int)$usuario['selecao_id']===(int)$s['id'])?'selected':'' ?>>
                        <?= htmlspecialchars($s['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn" type="submit">Salvar</button>
        <a class="btn" href="index.php?controller=Usuarios&action=index">Voltar</a>
    </form>
</section>

