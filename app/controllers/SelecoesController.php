<?php
class SelecoesController extends Controller {
    public function index(): void {
        $model = new Selecao();
        $selecoes = $model->all();
        $this->render('selecoes/index', ['selecoes' => $selecoes]);
    }

    public function create(): void {
        $grupos = (new Grupo())->all();
        $this->render('selecoes/create', ['grupos' => $grupos, 'error' => null]);
    }

    public function store(): void {
        $nome = trim($_POST['nome'] ?? '');
        $continente = trim($_POST['continente'] ?? '');
        $grupo_id = (int)($_POST['grupo_id'] ?? 0);
        try {
            (new Selecao())->create($nome, $continente, $grupo_id);
            header('Location: ' . BASE_URL . 'public/index.php?controller=Selecoes&action=index');
        } catch (Throwable $e) {
            $grupos = (new Grupo())->all();
            $this->render('selecoes/create', ['grupos' => $grupos, 'error' => $e->getMessage()]);
        }
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $model = new Selecao();
        $selecao = $model->find($id);
        $grupos = (new Grupo())->all();
        if (!$selecao) {
            $this->render('selecoes/index', ['selecoes' => $model->all(), 'error' => 'Seleção não encontrada.']);
            return;
        }
        $this->render('selecoes/edit', ['selecao' => $selecao, 'grupos' => $grupos, 'error' => null]);
    }

    public function update(): void {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $continente = trim($_POST['continente'] ?? '');
        $grupo_id = (int)($_POST['grupo_id'] ?? 0);
        try {
            (new Selecao())->update($id, $nome, $continente, $grupo_id);
            header('Location: ' . BASE_URL . 'public/index.php?controller=Selecoes&action=index');
        } catch (Throwable $e) {
            $model = new Selecao();
            $selecao = $model->find($id);
            $grupos = (new Grupo())->all();
            $this->render('selecoes/edit', ['selecao' => $selecao, 'grupos' => $grupos, 'error' => $e->getMessage()]);
        }
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            (new Selecao())->delete($id);
        } catch (Throwable $e) {
            // Ignora erro específico, apenas exibe mensagem na listagem
        }
        header('Location: ' . BASE_URL . 'public/index.php?controller=Selecoes&action=index');
    }
}

