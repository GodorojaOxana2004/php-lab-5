<?php
/**
 * Подключение к базе данных
 * @return PDO
 * @throws PDOException
 */
function getConnection() {
    static $pdo = null;
    if ($pdo === null) {
        $config = require __DIR__ . '/../config/db.php';
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        $pdo = new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

/**
 * Получение списка задач
 * @param PDO $pdo Подключение к БД
 * @param int $limit Количество задач
 * @param int $page Номер страницы
 * @return array
 */
function getTasks($pdo, $limit, $page = 1) {
    $offset = ($page - 1) * $limit;
    $stmt = $pdo->prepare("
        SELECT t.*, c.name as category_name
        FROM tasks t
        JOIN categories c ON t.category_id = c.id
        ORDER BY t.created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Получение общего количества задач
 * @param PDO $pdo Подключение к БД
 * @return int
 */
function getTotalTasks($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM tasks");
    return (int)$stmt->fetchColumn();
}

/**
 * Получение задачи по ID
 * @param PDO $pdo Подключение к БД
 * @param int $id ID задачи
 * @return array|null
 */
function getTaskById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT t.*, c.name as category_name
        FROM tasks t
        JOIN categories c ON t.category_id = c.id
        WHERE t.id = :id
    ");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch() ?: null;
}

/**
 * Получение списка категорий
 * @param PDO $pdo Подключение к БД
 * @return array
 */
function getCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories");
    return $stmt->fetchAll();
}
?>