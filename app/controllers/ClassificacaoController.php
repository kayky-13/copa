<?php
class ClassificacaoController extends Controller {
    public function index(): void {
        $grupos = (new Grupo())->all();
        $data = [];
        foreach ($grupos as $g) {
            $data[$g['letra']] = $this->classificacaoDoGrupo((int)$g['id']);
        }
        $this->render('classificacao/index', ['grupos' => $grupos, 'tabelas' => $data]);
    }

   
    private function classificacaoDoGrupo(int $grupo_id): array {
        $sql = "SELECT s.id, s.nome,
                       COALESCE(e.pontos, 0) AS pontos,
                       COALESCE(e.saldo_gols, 0) AS saldo_gols,
                       COALESCE(e.gols_pro, 0) AS gols_pro,
                       COALESCE(e.gols_contra, 0) AS gols_contra,
                       COALESCE(e.vitorias, 0) AS vitorias,
                       COALESCE(e.empates, 0) AS empates,
                       COALESCE(e.derrotas, 0) AS derrotas,
                       COALESCE(e.jogos, 0) AS jogos
                FROM selecoes s
                LEFT JOIN estatisticas_selecao e ON e.selecao_id = s.id
                WHERE s.grupo_id = ?
                ORDER BY pontos DESC, saldo_gols DESC, gols_pro DESC, s.nome ASC";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute([$grupo_id]);
        return $stmt->fetchAll();
    }

    private function db(): PDO {
        return Database::getConnection();
    }
}

