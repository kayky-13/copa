<?php
// Model de Estatísticas (persistente) com recálculo robusto
class EstatisticaSelecao extends Model {
    public function ensureRow(int $selecao_id): void {
        $stmt = $this->db->prepare("SELECT selecao_id FROM estatisticas_selecao WHERE selecao_id = ?");
        $stmt->execute([$selecao_id]);
        if (!$stmt->fetch()) {
            $stmt = $this->db->prepare("INSERT INTO estatisticas_selecao (selecao_id, jogos, vitorias, empates, derrotas, gols_pro, gols_contra, saldo_gols, pontos)
                                        VALUES (?, 0, 0, 0, 0, 0, 0, 0, 0)");
            $stmt->execute([$selecao_id]);
        }
    }

    // Recalcula estatísticas agregando todos os resultados dos jogos da fase de grupos do mesmo grupo da seleção
    public function recalcBySelecao(int $selecao_id): void {
        $this->ensureRow($selecao_id);
        // Descobrir o grupo da seleção
        $stmt = $this->db->prepare("SELECT grupo_id FROM selecoes WHERE id = ?");
        $stmt->execute([$selecao_id]);
        $row = $stmt->fetch();
        if (!$row) return;
        $grupo_id = (int)$row['grupo_id'];

        // Buscar todos os jogos da seleção naquele grupo com resultados registrados
        $sql = "SELECT j.id, j.mandante_id, j.visitante_id, r.gols_mandante, r.gols_visitante
                FROM jogos j
                INNER JOIN resultados r ON r.jogo_id = j.id
                WHERE j.grupo_id = ? AND (j.mandante_id = ? OR j.visitante_id = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$grupo_id, $selecao_id, $selecao_id]);
        $rows = $stmt->fetchAll();

        $jogos = 0; $vitorias = 0; $empates = 0; $derrotas = 0;
        $gols_pro = 0; $gols_contra = 0;

        foreach ($rows as $j) {
            $jogos++;
            $isMandante = ((int)$j['mandante_id'] === $selecao_id);
            $gf = $isMandante ? (int)$j['gols_mandante'] : (int)$j['gols_visitante'];
            $ga = $isMandante ? (int)$j['gols_visitante'] : (int)$j['gols_mandante'];
            $gols_pro += $gf;
            $gols_contra += $ga;
            if ($gf > $ga) $vitorias++;
            elseif ($gf === $ga) $empates++;
            else $derrotas++;
        }

        $saldo = $gols_pro - $gols_contra;
        $pontos = $vitorias * 3 + $empates * 1;

        $up = $this->db->prepare("UPDATE estatisticas_selecao
                                  SET jogos = ?, vitorias = ?, empates = ?, derrotas = ?, gols_pro = ?, gols_contra = ?, saldo_gols = ?, pontos = ?
                                  WHERE selecao_id = ?");
        $up->execute([$jogos, $vitorias, $empates, $derrotas, $gols_pro, $gols_contra, $saldo, $pontos, $selecao_id]);
    }
}

