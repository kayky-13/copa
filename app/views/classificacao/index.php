<section>
    <h2>Classificação por Grupo</h2>
    <?php foreach ($grupos as $g): ?>
        <h3>Grupo <?= htmlspecialchars($g['letra']) ?></h3>
        <table>
            <thead>
            <tr>
                <th>Seleção</th>
                <th>Pontos</th>
                <th>Jogos</th>
                <th>Vitórias</th>
                <th>Empates</th>
                <th>Derrotas</th>
                <th>Gols Pró</th>
                <th>Gols Contra</th>
                <th>Saldo</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tabelas[$g['letra']] as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= (int)$row['pontos'] ?></td>
                    <td><?= (int)$row['jogos'] ?></td>
                    <td><?= (int)$row['vitorias'] ?></td>
                    <td><?= (int)$row['empates'] ?></td>
                    <td><?= (int)$row['derrotas'] ?></td>
                    <td><?= (int)$row['gols_pro'] ?></td>
                    <td><?= (int)$row['gols_contra'] ?></td>
                    <td><?= (int)$row['saldo_gols'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</section>

