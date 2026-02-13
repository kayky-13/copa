<?php

class Router {
    public function dispatch(): void {
        $controllerName = isset($_GET['controller']) ? $_GET['controller'] . 'Controller' : 'ClassificacaoController';
        $action = $_GET['action'] ?? 'index';

        if (!class_exists($controllerName)) {
            echo "<p>Controller não encontrado: {$controllerName}</p>";
            return;
        }
        $controller = new $controllerName();
        if (!method_exists($controller, $action)) {
            echo "<p>Ação não encontrada: {$action}</p>";
            return;
        }
        $controller->$action();
    }
}

