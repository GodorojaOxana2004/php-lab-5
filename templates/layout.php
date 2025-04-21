<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Система управления задачами</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 10px; }
        .error { color: red; }
        .step { margin: 10px 0; display: flex; }
        .step textarea { width: 80%; margin-right: 10px; }
        .remove-step { color: red; cursor: pointer; }
    </style>
</head>
<body>
    <nav>
        <a href="/">Главная</a> |
        <a href="/tasks">Все задачи</a> |
        <a href="/task/create">Добавить задачу</a>
    </nav>
    <?= $content ?>
    <script src="/js/script.js"></script>
</body>
</html>