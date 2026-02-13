<?php
class UsuariosController extends Controller {
    public function index(): void {
        $usuarios = (new Usuario())->all();
        $this->render('usuarios/index', ['usuarios' => $usuarios]);
    }

    public function create(): void {
        $selecoes = (new Selecao())->all();
        $this->render('usuarios/create', ['selecoes' => $selecoes, 'error' => null]);
    }

    public function store(): void {
        $nome = trim($_POST['nome'] ?? '');
        $idade = (int)($_POST['idade'] ?? 0);
        $cargo = trim($_POST['cargo'] ?? '');
        $selecao_id = (int)($_POST['selecao_id'] ?? 0);
        try {
            (new Usuario())->create($nome, $idade, $cargo, $selecao_id);
            header('Location: ' . BASE_URL . 'public/index.php?controller=Usuarios&action=index');
        } catch (Throwable $e) {
            $selecoes = (new Selecao())->all();
            $this->render('usuarios/create', ['selecoes' => $selecoes, 'error' => $e->getMessage()]);
        }
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $usuario = (new Usuario())->find($id);
        $selecoes = (new Selecao())->all();
        if (!$usuario) {
            $this->render('usuarios/index', ['usuarios' => (new Usuario())->all(), 'error' => 'Usuário não encontrado.']);
            return;
        }
        $this->render('usuarios/edit', ['usuario' => $usuario, 'selecoes' => $selecoes, 'error' => null]);
    }

    public function update(): void {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $idade = (int)($_POST['idade'] ?? 0);
        $cargo = trim($_POST['cargo'] ?? '');
        $selecao_id = (int)($_POST['selecao_id'] ?? 0);
        try {
            (new Usuario())->update($id, $nome, $idade, $cargo, $selecao_id);
            header('Location: ' . BASE_URL . 'public/index.php?controller=Usuarios&action=index');
        } catch (Throwable $e) {
            $usuario = (new Usuario())->find($id);
            $selecoes = (new Selecao())->all();
            $this->render('usuarios/edit', ['usuario' => $usuario, 'selecoes' => $selecoes, 'error' => $e->getMessage()]);
        }
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        try {
            (new Usuario())->delete($id);
        } catch (Throwable $e) {
     
        }
        header('Location: ' . BASE_URL . 'public/index.php?controller=Usuarios&action=index');
    }
}

