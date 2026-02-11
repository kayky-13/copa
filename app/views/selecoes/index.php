<section>
    <h2>Seleções</h2>
    <p><a class="btn" href="index.php?controller=Selecoes&action=create">Criar Seleção</a></p>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Continente</th>
                <th>Grupo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($selecoes as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['nome']) ?></td>
                <td><?= htmlspecialchars($s['continente']) ?></td>
                <td><?= htmlspecialchars($s['grupo'] ?? '-') ?></td>
                <td>
                    <a class="btn" href="index.php?controller=Selecoes&action=edit&id=<?= (int)$s['id'] ?>">Editar</a>
                    <a class="btn danger" href="index.php?controller=Selecoes&action=delete&id=<?= (int)$s['id'] ?>" onclick="return confirm('Excluir seleção?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

