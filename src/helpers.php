<?php
/**
 * Рендерит шаблон с передачей данных
 * @param string $template Имя шаблона
 * @param array $data Данные для шаблона
 */
function render($template, $data = []) {
    extract($data);
    ob_start();
    require_once __DIR__ . '/../templates/' . $template . '.php';
    $content = ob_get_clean();
    require_once __DIR__ . '/../templates/layout.php';
}

/**
 * Возвращает значение поля формы или пустую строку
 * @param string $field Имя поля
 * @return string
 */
function getFormValue($field) {
    return htmlspecialchars($_POST[$field] ?? '');
}

/**
 * Проверяет, выбрано ли значение в выпадающем списке
 * @param string $field Имя поля
 * @param string $value Значение
 * @param bool $isArray Проверять как массив
 * @return string
 */
function isSelected($field, $value, $isArray = false) {
    if ($isArray) {
        return in_array($value, $_POST[$field] ?? []) ? 'selected' : '';
    }
    return ($_POST[$field] ?? '') === $value ? 'selected' : '';
}