<?php
/**
 * Обработчик редактирования задачи
 */
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../helpers.php';

$errors = [];
$pdo = getConnection();
$id = (int)$_GET['id'];
$task = getTaskById($pdo, $id);

if (!$task) {
    http_response_code(404);
    echo '404 Not Found';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) ?? [];
    $steps = filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) ?? [];

    // Валидация
    if (!$title) {
        $errors['title'] = 'Введите название задачи';
    }
    if (!$category_id) {
        $errors['category_id'] = 'Выберите категорию';
    }
    if (!$description) {
        $errors['description'] = 'Добавьте описание';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE tasks
            SET title = :title, category_id = :category_id, description = :description, tags = :tags, steps = :steps
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'category_id' => $category_id,
            'description' => $description,
            'tags' => implode(',', $tags),
            'steps' => implode("\n", array_filter($steps)),
        ]);
        header('Location: /task/show?id=' . $id);
        exit;
    }
}

render('task/edit', [
    'task' => $task,
    'categories' => getCategories($pdo),
    'errors' => $errors,
]);