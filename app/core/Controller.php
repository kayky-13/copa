<?php
// Base Controller com renderização de Views
abstract class Controller {
    protected function render(string $view, array $data = []): void {
        extract($data);
        $viewPath = BASE_PATH . '/app/views/' . $view . '.php';
        $headerPath = BASE_PATH . '/app/views/layout/header.php';
        $footerPath = BASE_PATH . '/app/views/layout/footer.php';

        if (file_exists($headerPath)) require $headerPath;
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "<p>View não encontrada: {$view}</p>";
        }
        if (file_exists($footerPath)) require $footerPath;
    }
}

