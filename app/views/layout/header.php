<?php
$cssFile = BASE_PATH . '/assets/css/style.css';
$css = file_exists($cssFile) ? file_get_contents($cssFile) : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Gerenciamento Copa do Mundo</title>
    <style><?= $css ?></style>
</head>
<body>
    <header class="topbar">
        <h1>Gerenciamento da Copa do Mundo</h1>
        <nav class="menu">
            <a href="index.php?controller=Selecoes&action=index">Seleções</a>
            <a href="index.php?controller=Usuarios&action=index">Usuários</a>
            <a href="index.php?controller=Grupos&action=index">Grupos</a>
            <a href="index.php?controller=Jogos&action=index">Jogos</a>
            <a href="index.php?controller=Resultados&action=index">Resultados</a>
            <a href="index.php?controller=Classificacao&action=index">Classificação</a>
        </nav>
    </header>
    <main class="container">
