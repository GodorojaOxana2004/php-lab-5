<?php
/**
 * Конфигурация подключения к базе данных SQLite
 * @return array Ассоциативный массив с параметрами подключения
 */
return [
    'dsn' => 'sqlite:' . __DIR__ . '/../storage/tasks.db',
];