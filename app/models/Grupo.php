<?php

class Grupo extends Model {
    public function all(): array {
        $stmt = $this->db->query("SELECT id, letra FROM grupos ORDER BY letra ASC");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, letra FROM grupos WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $letra): int {
        if ($letra === '') {
            throw new InvalidArgumentException("Letra do grupo Ã© obrigatÃ³ria.");
        }
        $stmt = $this->db->prepare("INSERT INTO grupos (letra) VALUES (?)");
        $stmt->execute([$letra]);
        return (int)$this->db->lastInsertId();
    }
    public function delete(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException("Grupo inválido para exclusão.");
        }

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM selecoes WHERE grupo_id = ?");
        $stmt->execute([$id]);
        $totalSelecoes = (int)$stmt->fetchColumn();
        if ($totalSelecoes > 0) {
            throw new RuntimeException("Não é possível excluir o grupo com seleções vinculadas.");
        }

        $stmt = $this->db->prepare("DELETE FROM grupos WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("Grupo não encontrado ou já excluído.");
        }
    }
}