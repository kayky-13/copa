<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'cop_word');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');


$basePath = dirname(__DIR__, 2);
define('BASE_PATH', $basePath);
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$publicPos = strpos($scriptName, '/public/index.php');
$projectBase = $publicPos !== false ? substr($scriptName, 0, $publicPos) : '';
$projectBase = rtrim($projectBase, '/');

define('BASE_URL', ($projectBase === '' ? '/' : $projectBase . '/'));

function app_url(string $query = ''): string {
    $url = BASE_URL . 'public/index.php';
    if ($query !== '') {
        $separator = str_starts_with($query, '?') ? '' : '?';
        $url .= $separator . $query;
    }
    return $url;
}
