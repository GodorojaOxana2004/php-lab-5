<?php
require_once __DIR__ . '/../src/db.php';

try {
    $pdo = getConnection();
    echo "Подключение к базе данных успешно!";
    $stmt = $pdo->query("SELECT * FROM categories");
    print_r($stmt->fetchAll());
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>