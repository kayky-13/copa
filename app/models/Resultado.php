<?php

class Resultado extends Model {
    public function findByJogo(int $jogo_id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM resultados WHERE jogo_id = ?");
        $stmt->execute([$jogo_id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function upsert(int $jogo_id, int $gols_mandante, int $gols_visitante): void {
        if ($jogo_id <= 0 || $gols_mandante < 0 || $gols_visitante < 0) {
            throw new InvalidArgumentException("Dados de resultado inválidos.");
        }
        $jogoModel = new Jogo();
        $jogo = $jogoModel->find($jogo_id);
        if (!$jogo) {
            throw new InvalidArgumentException("Jogo inexistente.");
        }
        
        $exists = $this->findByJogo($jogo_id);
        if ($exists) {
            $stmt = $this->db->prepare("UPDATE resultados SET gols_mandante = ?, gols_visitante = ? WHERE jogo_id = ?");
            $stmt->execute([$gols_mandante, $gols_visitante, $jogo_id]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO resultados (jogo_id, gols_mandante, gols_visitante) VALUES (?, ?, ?)");
            $stmt->execute([$jogo_id, $gols_mandante, $gols_visitante]);
        }
        
        $stats = new EstatisticaSelecao();
        $stats->recalcBySelecao((int)$jogo['mandante_id']);
        $stats->recalcBySelecao((int)$jogo['visitante_id']);
    }
}

