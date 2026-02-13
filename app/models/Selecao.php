<?php

class Selecao extends Model {
    public function all(): array {
        $sql = "SELECT s.id, s.nome, s.continente, s.grupo_id, g.letra AS grupo
                FROM selecoes s
                LEFT JOIN grupos g ON g.id = s.grupo_id
                ORDER BY s.nome ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, nome, continente, grupo_id FROM selecoes WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $nome, string $continente, int $grupo_id): int {
        if ($nome === '' || $continente === '' || $grupo_id <= 0) {
            throw new InvalidArgumentException("Campos obrigatórios da seleção não informados.");
        }
        $this->assertGrupoExists($grupo_id);
        $stmt = $this->db->prepare("INSERT INTO selecoes (nome, continente, grupo_id) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $continente, $grupo_id]);
        $id = (int)$this->db->lastInsertId();
        (new EstatisticaSelecao())->ensureRow($id);
        return $id;
    }

    public function update(int $id, string $nome, string $continente, int $grupo_id): void {
        if ($id <= 0 || $nome === '' || $continente === '' || $grupo_id <= 0) {
            throw new InvalidArgumentException("Campos obrigatórios da seleção não informados.");
        }
        $this->assertGrupoExists($grupo_id);
        $stmt = $this->db->prepare("UPDATE selecoes SET nome = ?, continente = ?, grupo_id = ? WHERE id = ?");
        $stmt->execute([$nome, $continente, $grupo_id, $id]);
        (new EstatisticaSelecao())->ensureRow($id);
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM selecoes WHERE id = ?");
        $stmt->execute([$id]);
        
    }

    public function byGrupo(int $grupo_id): array {
        $stmt = $this->db->prepare("SELECT id, nome, continente, grupo_id FROM selecoes WHERE grupo_id = ? ORDER BY nome ASC");
        $stmt->execute([$grupo_id]);
        return $stmt->fetchAll();
    }

    private function assertGrupoExists(int $grupo_id): void {
        $stmt = $this->db->prepare("SELECT id FROM grupos WHERE id = ?");
        $stmt->execute([$grupo_id]);
        if (!$stmt->fetch()) {
            throw new InvalidArgumentException("Grupo inexistente.");
        }
    }
}

