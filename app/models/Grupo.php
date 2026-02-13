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
            throw new InvalidArgumentException("Letra do grupo é obrigatória.");
        }
        $stmt = $this->db->prepare("INSERT INTO grupos (letra) VALUES (?)");
        $stmt->execute([$letra]);
        return (int)$this->db->lastInsertId();
    }
}

