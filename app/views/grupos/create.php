<section>
    <h2>Criar Grupo</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="index.php?controller=Grupos&action=store">
        <label>Letra do Grupo
            <input type="text" name="letra" maxlength="1" required>
        </label>
        <button class="btn" type="submit">Salvar</button>
        <a class="btn" href="index.php?controller=Grupos&action=index">Voltar</a>
    </form>
</section>

