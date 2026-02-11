<section>
    <h2>Registrar/Editar Resultado</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <p>
        <strong>Jogo:</strong>
        <?= htmlspecialchars($jogo['data_hora']) ?> —
        <?= htmlspecialchars((new Selecao())->find((int)$jogo['mandante_id'])['nome'] ?? '') ?>
        x
        <?= htmlspecialchars((new Selecao())->find((int)$jogo['visitante_id'])['nome'] ?? '') ?>
        (<?= htmlspecialchars($jogo['estadio']) ?>, <?= htmlspecialchars($jogo['fase']) ?>)
    </p>
    <form method="post" action="index.php?controller=Resultados&action=update">
        <input type="hidden" name="jogo_id" value="<?= (int)$jogo['id'] ?>">
        <label>Gols Mandante
            <input type="number" name="gols_mandante" min="0" value="<?= isset($resultado['gols_mandante']) ? (int)$resultado['gols_mandante'] : 0 ?>" required>
        </label>
        <label>Gols Visitante
            <input type="number" name="gols_visitante" min="0" value="<?= isset($resultado['gols_visitante']) ? (int)$resultado['gols_visitante'] : 0 ?>" required>
        </label>
        <button class="btn" type="submit">Salvar</button>
        <a class="btn" href="index.php?controller=Resultados&action=index">Voltar</a>
    </form>
</section>

