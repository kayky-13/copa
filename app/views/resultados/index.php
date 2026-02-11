<section>
    <h2>Resultados</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <table>
        <thead>
        <tr>
            <th>Data/Hora</th>
            <th>Mandante</th>
            <th>Visitante</th>
            <th>Placar</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($jogos as $j): ?>
            <?php $res = (new Resultado())->findByJogo((int)$j['id']); ?>
            <tr>
                <td><?= htmlspecialchars($j['data_hora']) ?></td>
                <td><?= htmlspecialchars($j['mandante']) ?></td>
                <td><?= htmlspecialchars($j['visitante']) ?></td>
                <td><?= $res ? (int)$res['gols_mandante'] . ' x ' . (int)$res['gols_visitante'] : '-' ?></td>
                <td>
                    <a class="btn" href="index.php?controller=Resultados&action=edit&jogo_id=<?= (int)$j['id'] ?>">Registrar/Editar Resultado</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

