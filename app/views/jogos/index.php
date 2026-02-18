<section>
    <h2>Jogos</h2>
    <p><a class="btn" href="index.php?controller=Jogos&action=create">Criar Jogo</a></p>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <table>
        <thead>
        <tr>
            <th>Data/Hora</th>
            <th>Mandante</th>
            <th>Visitante</th>
            <th>Estádio</th>
            <th>Fase</th>
            <th>Grupo</th>
            <th>Resultado</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($jogos as $j): ?>
            <tr>
                <td><?= htmlspecialchars($j['data_hora']) ?></td>
                <td><?= htmlspecialchars($j['mandante']) ?></td>
                <td><?= htmlspecialchars($j['visitante']) ?></td>
                <td><?= htmlspecialchars($j['estadio']) ?></td>
                <td><?= htmlspecialchars($j['fase']) ?></td>
                <td><?= htmlspecialchars($j['grupo'] ?? '-') ?></td>
                <td>
                    <?php
                   
                    $resModel = new Resultado();
                    $res = $resModel->findByJogo((int)$j['id']);
                    echo $res ? (int)$res['gols_mandante'] . ' x ' . (int)$res['gols_visitante'] : '-';
                    ?>
                </td>
                <td>
                    <a class="btn" href="index.php?controller=Resultados&action=edit&jogo_id=<?= (int)$j['id'] ?>">Registrar/Editar Resultado</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

