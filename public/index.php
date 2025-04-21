<?php
/**
 * Единая точка входа для обработки всех HTTP-запросов
 */
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/db.php';

// Простая маршрутизация
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/':
        $tasks = getLatestTasks();
        $content = renderTemplate(__DIR__ . '/../templates/index.php', ['tasks' => $tasks]);
        echo renderLayout($content);
        break;

    case '/tasks':
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $tasksData = getTasksWithPagination($page);
        $content = renderTemplate(__DIR__ . '/../templates/task/show.php', [
            'tasks' => $tasksData['tasks'],
            'page' => $page,
            'totalPages' => $tasksData['totalPages']
        ]);
        echo renderLayout($content);
        break;

    case '/task/create':
        if ($method === 'POST') {
            require __DIR__ . '/../src/handlers/task/create.php';
        } else {
            $categories = getCategories();
            $content = renderTemplate(__DIR__ . '/../templates/task/create.php', [
                'categories' => $categories,
                'errors' => []
            ]);
            echo renderLayout($content);
        }
        break;

    case '/task/edit':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($method === 'POST') {
            require __DIR__ . '/../src/handlers/task/edit.php';
        } else {
            $task = getTaskById($id);
            $categories = getCategories();
            if ($task) {
                $content = renderTemplate(__DIR__ . '/../templates/task/edit.php', [
                    'task' => $task,
                    'categories' => $categories,
                    'errors' => []
                ]);
                echo renderLayout($content);
            } else {
                http_response_code(404);
                echo renderLayout('<h1>Задача не найдена</h1>');
            }
        }
        break;

    case '/task/delete':
        if ($method === 'POST') {
            require __DIR__ . '/../src/handlers/task/delete.php';
        }
        break;

    default:
        http_response_code(404);
        echo renderLayout('<h1>Страница не найдена</h1>');
        break;
}

/**
 * Получить последние 2 задачи
 * @return array Массив объектов задач
 */
function getLatestTasks(): array {
    $pdo = getDbConnection();
    $stmt = $pdo->query('SELECT t.*, c.name as category_name 
                         FROM tasks t 
                         JOIN categories c ON t.category_id = c.id 
                         ORDER BY t.created_at DESC 
                         LIMIT 2');
    return $stmt->fetchAll();
}

/**
 * Получить задачи с пагинацией
 * @param int $page Номер текущей страницы
 * @return array Массив с задачами и данными пагинации
 */
function getTasksWithPagination(int $page): array {
    $perPage = 5;
    $pdo = getDbConnection();
    
    // Подсчет общего количества задач
    $stmt = $pdo->query('SELECT COUNT(*) FROM tasks');
    $totalTasks = $stmt->fetchColumn();
    $totalPages = ceil($totalTasks / $perPage);
    
    // Ограничение страницы
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;
    
    // Получение задач для текущей страницы
    $stmt = $pdo->prepare('SELECT t.*, c.name as category_name 
                           FROM tasks t 
                           JOIN categories c ON t.category_id = c.id 
                           ORDER BY t.created_at DESC 
                           LIMIT :limit OFFSET :offset');
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return [
        'tasks' => $stmt->fetchAll(),
        'totalPages' => $totalPages
    ];
}

/**
 * Получить все категории
 * @return array Массив объектов категорий
 */
function getCategories(): array {
    $pdo = getDbConnection();
    $stmt = $pdo->query('SELECT * FROM categories');
    return $stmt->fetchAll();
}

/**
 * Получить задачу по ID
 * @param int $id ID задачи
 * @return object|null Объект задачи или null, если не найдена
 */
function getTaskById(int $id): ?object {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT t.*, c.name as category_name 
                           FROM tasks t 
                           JOIN categories c ON t.category_id = c.id 
                           WHERE t.id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $task = $stmt->fetch();
    return $task ?: null;
}

/**
 * Отрисовать шаблон с данными
 * @param string $templatePath Путь к файлу шаблона
 * @param array $data Данные для шаблона
 * @return string Отрисованный HTML
 */
function renderTemplate(string $templatePath, array $data = []): string {
    extract($data);
    ob_start();
    require $templatePath;
    return ob_get_clean();
}

/**
 * Отрисовать страницу с использованием базового шаблона
 * @param string $content Контент страницы
 * @return string Полный HTML страницы
 */
function renderLayout(string $content): string {
    ob_start();
    require __DIR__ . '/../templates/layout.php';
    return ob_get_clean();
}