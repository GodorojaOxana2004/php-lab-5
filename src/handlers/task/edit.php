<?php
/**
 * Обработчик редактирования задачи
 */
require_once __DIR__ . '/../../helpers.php';
require_once __DIR__ . '/../../db.php';

$errors = [];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Фильтрация и валидация данных
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) ?? [];
$steps = filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) ?? [];

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
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('UPDATE tasks 
                           SET title = :title, category_id = :category_id, description = :description, 
                               tags = :tags, steps = :steps 
                           WHERE id = :id');
    $stmt->execute([
        'id' => $id,
        'title' => $title,
        'category_id' => $category_id,
        'description' => $description,
        'tags' => json_encode($tags),
        'steps' => json_encode(array_filter($steps))
    ]);
    header('Location: /tasks');
    exit;
} else {
    $task = getTaskById($id);
    $categories = getCategories();
    $content = renderTemplate(__DIR__ . '/../../../templates/task/edit.php', [
        'task' => $task,
        'categories' => $categories,
        'errors' => $errors
    ]);
    echo renderLayout($content);
}