<?php

class Jogo extends Model {
    public function all(): array {
        $sql = "SELECT j.id, j.mandante_id, j.visitante_id, j.data_hora, j.estadio, j.fase, j.grupo_id,
                       sm.nome AS mandante, sv.nome AS visitante, g.letra AS grupo
                FROM jogos j
                LEFT JOIN selecoes sm ON sm.id = j.mandante_id
                LEFT JOIN selecoes sv ON sv.id = j.visitante_id
                LEFT JOIN grupos g ON g.id = j.grupo_id
                ORDER BY j.data_hora ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM jogos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(int $mandante_id, int $visitante_id, string $data_hora, string $estadio, string $fase, ?int $grupo_id): int {
        if ($mandante_id <= 0 || $visitante_id <= 0 || $data_hora === '' || $estadio === '' || $fase === '') {
            throw new InvalidArgumentException("Campos obrigatórios do jogo não informados.");
        }
        if ($mandante_id === $visitante_id) {
            throw new InvalidArgumentException("Mandante e visitante não podem ser a mesma seleção.");
        }
        $this->assertSelecaoExists($mandante_id);
        $this->assertSelecaoExists($visitante_id);
        if ($grupo_id !== null) {
            $this->assertGrupoExists($grupo_id);
            $this->assertSelecoesNoMesmoGrupo($mandante_id, $visitante_id, $grupo_id);
        }
        $stmt = $this->db->prepare("INSERT INTO jogos (mandante_id, visitante_id, data_hora, estadio, fase, grupo_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$mandante_id, $visitante_id, $data_hora, $estadio, $fase, $grupo_id]);
        return (int)$this->db->lastInsertId();
    }

    private function assertSelecaoExists(int $id): void {
        $stmt = $this->db->prepare("SELECT id FROM selecoes WHERE id = ?");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            throw new InvalidArgumentException("Seleção inexistente.");
        }
    }

    private function assertGrupoExists(int $grupo_id): void {
        $stmt = $this->db->prepare("SELECT id FROM grupos WHERE id = ?");
        $stmt->execute([$grupo_id]);
        if (!$stmt->fetch()) {
            throw new InvalidArgumentException("Grupo inexistente.");
        }
    }

    private function assertSelecoesNoMesmoGrupo(int $mandante_id, int $visitante_id, int $grupo_id): void {
        $stmt = $this->db->prepare("SELECT COUNT(*) c FROM selecoes WHERE id IN (?, ?) AND grupo_id = ?");
        $stmt->execute([$mandante_id, $visitante_id, $grupo_id]);
        $row = $stmt->fetch();
        if ((int)$row['c'] !== 2) {
            throw new InvalidArgumentException("Para jogos da fase de grupos, as seleções devem pertencer ao mesmo grupo.");
        }
    }
}

