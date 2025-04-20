<?php
/**
 * Обработчик удаления задачи
 */
require_once __DIR__ . '/../../db.php';

$pdo = getConnection();
$id = (int)$_GET['id'];

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: /tasks');
exit;