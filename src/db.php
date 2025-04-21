<?php
/**
 * Подключение к базе данных SQLite с использованием PDO
 * @return PDO Экземпляр PDO для работы с базой данных
 * @throws PDOException Если подключение не удалось
 */
function getDbConnection(): PDO {
    $config = require __DIR__ . '/../config/db.php';
    
    try {
        $pdo = new PDO($config['dsn']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $pdo;
    } catch (PDOException $e) {
        die('Ошибка подключения к базе данных: ' . $e->getMessage());
    }
}