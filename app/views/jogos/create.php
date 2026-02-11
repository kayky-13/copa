<section>
    <h2>Criar Jogo</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?controller=Jogos&action=store">
        <label>Mandante
            <select name="mandante_id" required>
                <option value="">Selecione...</option>
                <?php foreach ($selecoes as $s): ?>
                    <option value="<?= (int)$s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Visitante
            <select name="visitante_id" required>
                <option value="">Selecione...</option>
                <?php foreach ($selecoes as $s): ?>
                    <option value="<?= (int)$s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Data/Hora
            <input type="datetime-local" name="data_hora" required>
        </label>
        <label>Estádio
            <input type="text" name="estadio" required>
        </label>
        <label>Fase
            <input type="text" name="fase" required>
        </label>
        <label>Grupo (somente para fase de grupos)
            <select name="grupo_id">
                <option value="">Mata-mata / não aplicável</option>
                <?php foreach ($grupos as $g): ?>
                    <option value="<?= (int)$g['id'] ?>"><?= htmlspecialchars($g['letra']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn" type="submit">Salvar</button>
        <a class="btn" href="index.php?controller=Jogos&action=index">Voltar</a>
    </form>
</section>

