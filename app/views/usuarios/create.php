<section>
    <h2>Criar Usuário</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?controller=Usuarios&action=store">
        <label>Nome
            <input type="text" name="nome" required>
        </label>
        <label>Idade
            <input type="number" name="idade" min="1" required>
        </label>
        <label>Cargo
            <select name="cargo" required>
                <option value="jogador">jogador</option>
                <option value="técnico">técnico</option>
                <option value="árbitro">árbitro</option>
                <option value="outros">outros</option>
            </select>
        </label>
        <label>Seleção
            <select name="selecao_id" required>
                <option value="">Selecione...</option>
                <?php foreach ($selecoes as $s): ?>
                    <option value="<?= (int)$s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn" type="submit">Salvar</button>
        <a class="btn" href="index.php?controller=Usuarios&action=index">Voltar</a>
    </form>
</section>

