<?php
/**
 * Обработчик создания задачи
 */
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../helpers.php';

$errors = [];
$pdo = getConnection();

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
            INSERT INTO tasks (title, category_id, description, tags, steps)
            VALUES (:title, :category_id, :description, :tags, :steps)
        ");
        $stmt->execute([
            'title' => $title,
            'category_id' => $category_id,
            'description' => $description,
            'tags' => implode(',', $tags),
            'steps' => implode("\n", array_filter($steps)),
        ]);
        header('Location: /');
        exit;
    }
}

render('task/create', [
    'categories' => getCategories($pdo),
    'errors' => $errors,
]);