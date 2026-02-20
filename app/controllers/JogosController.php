<?php
class JogosController extends Controller {
    public function index(): void {
        $jogos = (new Jogo())->all();
        $this->render('jogos/index', ['jogos' => $jogos]);
    }

    public function create(): void {
        $selecoes = (new Selecao())->all();
        $grupos = (new Grupo())->all();
        $this->render('jogos/create', ['selecoes' => $selecoes, 'grupos' => $grupos, 'error' => null]);
    }

    public function store(): void {
        $mandante_id = (int)($_POST['mandante_id'] ?? 0);
        $visitante_id = (int)($_POST['visitante_id'] ?? 0);
        $data_hora = trim($_POST['data_hora'] ?? '');
        $estadio = trim($_POST['estadio'] ?? '');
        $fase = trim($_POST['fase'] ?? '');
        $grupo_id_raw = $_POST['grupo_id'] ?? '';
        $grupo_id = ($grupo_id_raw === '' ? null : (int)$grupo_id_raw);
        try {
            (new Jogo())->create($mandante_id, $visitante_id, $data_hora, $estadio, $fase, $grupo_id);
            header('Location: ' . app_url('controller=Jogos&action=index&status=success&msg=' . urlencode('Salvo com sucesso.')));
            exit;
        } catch (Throwable $e) {
            $selecoes = (new Selecao())->all();
            $grupos = (new Grupo())->all();
            $this->render('jogos/create', ['selecoes' => $selecoes, 'grupos' => $grupos, 'error' => $e->getMessage()]);
        }
    }
}
