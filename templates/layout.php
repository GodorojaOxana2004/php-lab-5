<?php
/**
 * Базовый шаблон для всех страниц
 * @param string $title Заголовок страницы
 * @param string $content Содержимое страницы
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Task Manager') ?></title>
    <style>
        .step { margin: 10px 0; display: flex; }
        .step textarea { width: 80%; margin-right: 10px; }
        .remove-step { color: red; cursor: pointer; }
        .error { color: red; }
    </style>
</head>
<body>
    <nav>
        <a href="/">Главная</a> |
        <a href="/tasks">Все задачи</a> |
        <a href="/task/create">Добавить задачу</a>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <script src="/js/script.js"></script>
</body>
</html>