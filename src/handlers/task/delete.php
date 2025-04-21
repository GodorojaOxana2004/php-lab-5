<?php
/**
 * Обработчик удаления задачи
 */
require_once __DIR__ . '/../../db.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

header('Location: /tasks');
exit;