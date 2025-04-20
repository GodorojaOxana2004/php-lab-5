<?php
/**
 * Единая точка входа для приложения
 */
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/db.php';

// Определяем маршрут
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
    case '/':
    case '/index':
        $tasks = getTasks($pdo, 2); // Последние 2 задачи
        render('index', ['tasks' => $tasks]);
        break;
    case '/tasks':
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $tasks = getTasks($pdo, 5, $page);
        $totalTasks = getTotalTasks($pdo);
        $totalPages = ceil($totalTasks / 5);
        render('tasks/index', ['tasks' => $tasks, 'page' => $page, 'totalPages' => $totalPages]);
        break;
    case '/task/create':
        if ($method === 'POST') {
            require_once __DIR__ . '/../src/handlers/task/create.php';
        } else {
            render('task/create', ['categories' => getCategories($pdo)]);
        }
        break;
    case '/task/edit':
        if ($method === 'POST') {
            require_once __DIR__ . '/../src/handlers/task/edit.php';
        } else {
            $id = (int)$_GET['id'];
            $task = getTaskById($pdo, $id);
            render('task/edit', ['task' => $task, 'categories' => getCategories($pdo)]);
        }
        break;
    case '/task/delete':
        require_once __DIR__ . '/../src/handlers/task/delete.php';
        break;
    case '/task/show':
        $id = (int)$_GET['id'];
        $task = getTaskById($pdo, $id);
        render('task/show', ['task' => $task]);
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
}