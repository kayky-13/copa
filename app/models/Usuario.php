<?php

class Usuario extends Model {
    private array $cargos = ['jogador', 'técnico', 'árbitro', 'outros'];

    public function all(): array {
        $sql = "SELECT u.id, u.nome, u.idade, u.cargo, u.selecao_id, s.nome AS selecao
                FROM usuarios u
                LEFT JOIN selecoes s ON s.id = u.selecao_id
                ORDER BY u.nome ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, nome, idade, cargo, selecao_id FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(string $nome, int $idade, string $cargo, int $selecao_id): int {
        if ($nome === '' || $idade <= 0 || $selecao_id <= 0) {
            throw new InvalidArgumentException("Campos obrigatórios do usuário não informados ou inválidos.");
        }
        if (!in_array(mb_strtolower($cargo), $this->cargos, true)) {
            throw new InvalidArgumentException("Cargo inválido.");
        }
        $this->assertSelecaoExists($selecao_id);
        $stmt = $this->db->prepare("INSERT INTO usuarios (nome, idade, cargo, selecao_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $idade, mb_strtolower($cargo), $selecao_id]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, string $nome, int $idade, string $cargo, int $selecao_id): void {
        if ($id <= 0 || $nome === '' || $idade <= 0 || $selecao_id <= 0) {
            throw new InvalidArgumentException("Campos obrigatórios do usuário não informados ou inválidos.");
        }
        if (!in_array(mb_strtolower($cargo), $this->cargos, true)) {
            throw new InvalidArgumentException("Cargo inválido.");
        }
        $this->assertSelecaoExists($selecao_id);
        $stmt = $this->db->prepare("UPDATE usuarios SET nome = ?, idade = ?, cargo = ?, selecao_id = ? WHERE id = ?");
        $stmt->execute([$nome, $idade, mb_strtolower($cargo), $selecao_id, $id]);
    }

    public function delete(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException("Usuário inválido para exclusão.");
        }
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("Usuário não encontrado ou já excluído.");
        }
    }

    private function assertSelecaoExists(int $selecao_id): void {
        $stmt = $this->db->prepare("SELECT id FROM selecoes WHERE id = ?");
        $stmt->execute([$selecao_id]);
        if (!$stmt->fetch()) {
            throw new InvalidArgumentException("Seleção inexistente.");
        }
    }
}
