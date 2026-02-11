<section>
    <h2>Seleções do Grupo <?= htmlspecialchars($grupo['letra']) ?></h2>
    <p><a class="btn" href="index.php?controller=Selecoes&action=create">Criar Seleção</a></p>
    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Continente</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($selecoes as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['nome']) ?></td>
                <td><?= htmlspecialchars($s['continente']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p><a class="btn" href="index.php?controller=Grupos&action=index">Voltar aos Grupos</a></p>
</section>

