<?php
class ResultadosController extends Controller {
    public function index(): void {
        $jogos = (new Jogo())->all();
        $this->render('resultados/index', ['jogos' => $jogos]);
    }

    public function edit(): void {
        $jogo_id = (int)($_GET['jogo_id'] ?? 0);
        $jogo = (new Jogo())->find($jogo_id);
        if (!$jogo) {
            $this->render('resultados/index', ['jogos' => (new Jogo())->all(), 'error' => 'Jogo não encontrado.']);
            return;
        }
        $resultado = (new Resultado())->findByJogo($jogo_id);
        $this->render('resultados/edit', ['jogo' => $jogo, 'resultado' => $resultado, 'error' => null]);
    }

    public function update(): void {
        $jogo_id = (int)($_POST['jogo_id'] ?? 0);
        $gols_mandante = (int)($_POST['gols_mandante'] ?? 0);
        $gols_visitante = (int)($_POST['gols_visitante'] ?? 0);
        try {
            (new Resultado())->upsert($jogo_id, $gols_mandante, $gols_visitante);
            header('Location: ' . app_url('controller=Resultados&action=index&status=success&msg=' . urlencode('Salvo com sucesso.')));
            exit;
        } catch (Throwable $e) {
            $jogo = (new Jogo())->find($jogo_id);
            $resultado = (new Resultado())->findByJogo($jogo_id);
            $this->render('resultados/edit', ['jogo' => $jogo, 'resultado' => $resultado, 'error' => $e->getMessage()]);
        }
    }
}
