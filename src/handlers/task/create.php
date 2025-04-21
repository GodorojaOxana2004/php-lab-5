<?php
/**
 * Обработчик добавления новой задачи
 */
require_once __DIR__ . '/../../helpers.php';
require_once __DIR__ . '/../../db.php';

$errors = [];

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
    $stmt = $pdo->prepare('INSERT INTO tasks (title, category_id, description, tags, steps) 
                           VALUES (:title, :category_id, :description, :tags, :steps)');
    $stmt->execute([
        'title' => $title,
        'category_id' => $category_id,
        'description' => $description,
        'tags' => json_encode($tags),
        'steps' => json_encode(array_filter($steps))
    ]);
    header('Location: /');
    exit;
} else {
    $categories = getCategories();
    $content = renderTemplate(__DIR__ . '/../../../templates/task/create.php', [
        'categories' => $categories,
        'errors' => $errors
    ]);
    echo renderLayout($content);
}