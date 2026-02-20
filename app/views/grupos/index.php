<section>
    <h2>Grupos</h2>
    <p><a class="btn" href="index.php?controller=Grupos&action=create">Criar Grupo</a></p>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <table>
        <thead>
        <tr>
            <th>Letra</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($grupos as $g): ?>
            <tr>
                <td><?= htmlspecialchars($g['letra']) ?></td>
                <td>
                    <a class="btn" href="index.php?controller=Grupos&action=selecoes&id=<?= (int)$g['id'] ?>">Seleções do Grupo</a>
                    <a class="btn danger" href="index.php?controller=Grupos&action=delete&id=<?= (int)$g['id'] ?>" onclick="return confirm('Excluir grupo?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

