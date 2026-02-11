<?php
class GruposController extends Controller {
    public function index(): void {
        $grupos = (new Grupo())->all();
        $this->render('grupos/index', ['grupos' => $grupos]);
    }

    public function create(): void {
        $this->render('grupos/create', ['error' => null]);
    }

    public function store(): void {
        $letra = strtoupper(trim($_POST['letra'] ?? ''));
        try {
            (new Grupo())->create($letra);
            header('Location: ' . BASE_URL . 'public/index.php?controller=Grupos&action=index');
        } catch (Throwable $e) {
            $this->render('grupos/create', ['error' => $e->getMessage()]);
        }
    }

    public function selecoes(): void {
        $id = (int)($_GET['id'] ?? 0);
        $grupo = (new Grupo())->find($id);
        if (!$grupo) {
            $this->render('grupos/index', ['grupos' => (new Grupo())->all(), 'error' => 'Grupo não encontrado.']);
            return;
        }
        $selecoes = (new Selecao())->byGrupo($id);
        $this->render('grupos/selecoes', ['grupo' => $grupo, 'selecoes' => $selecoes]);
    }
}

