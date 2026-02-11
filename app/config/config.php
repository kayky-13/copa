<?php
// Configurações de banco e aplicação
define('DB_HOST', 'localhost');
define('DB_NAME', 'cop_word');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Base path e URL base (ajuste BASE_URL conforme seu ambiente)
$basePath = dirname(__DIR__, 2);
define('BASE_PATH', $basePath);
define('BASE_URL', '/'); // em XAMPP/WAMP/Laragon, aponte DocumentRoot para /public

