<?php
$cssFile = BASE_PATH . '/assets/css/style.css';
$css = file_exists($cssFile) ? file_get_contents($cssFile) : '';

$currentController = $_GET['controller'] ?? '';
$currentAction = $_GET['action'] ?? 'index';

$menu = [
  ['label' => 'Grupos',        'controller' => 'Grupos',        'action' => 'index'],
  ['label' => 'Seleções',      'controller' => 'Selecoes',      'action' => 'index'],
  ['label' => 'Usuários',      'controller' => 'Usuarios',      'action' => 'index'],
  ['label' => 'Jogos',         'controller' => 'Jogos',         'action' => 'index'],
  ['label' => 'Resultados',    'controller' => 'Resultados',    'action' => 'index'],
  ['label' => 'Classificação', 'controller' => 'Classificacao', 'action' => 'index'],
];

function isActiveMenu(string $curC, string $curA, string $c, string $a): bool {

  if ($curC === '') return false;
  return strcasecmp($curC, $c) === 0 && strcasecmp($curA, $a) === 0;
}
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
    <div class="topbar-inner">
      <div class="brand">
        <h1>Gerenciamento da Copa do Mundo</h1>
        <div class="brand-sub">Painel • Cadastro • Jogos • Resultados • Classificação</div>
      </div>

      <nav class="menu" aria-label="Menu principal">
        <?php foreach ($menu as $item): ?>
          <?php
            $active = isActiveMenu($currentController, $currentAction, $item['controller'], $item['action']);
            $href = "index.php?controller={$item['controller']}&action={$item['action']}";
          ?>
          <a href="<?= htmlspecialchars($href) ?>"
             class="menu-item"
             <?= $active ? 'aria-current="page"' : '' ?>>
            <?= htmlspecialchars($item['label']) ?>
          </a>
        <?php endforeach; ?>
      </nav>
    </div>
  </header>

  <main class="container">
