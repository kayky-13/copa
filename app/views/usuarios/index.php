<section>
    <h2>Usuários</h2>
    <p><a class="btn" href="index.php?controller=Usuarios&action=create">Criar Usuário</a></p>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Idade</th>
            <th>Cargo</th>
            <th>Seleção</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['nome']) ?></td>
                <td><?= (int)$u['idade'] ?></td>
                <td><?= htmlspecialchars($u['cargo']) ?></td>
                <td><?= htmlspecialchars($u['selecao'] ?? '-') ?></td>
                <td>
                    <a class="btn" href="index.php?controller=Usuarios&action=edit&id=<?= (int)$u['id'] ?>">Editar</a>
                    <a class="btn danger" href="index.php?controller=Usuarios&action=delete&id=<?= (int)$u['id'] ?>" onclick="return confirm('Excluir usuário?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

