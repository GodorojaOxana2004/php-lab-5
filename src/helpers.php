<?php
/**
 * Возвращает значение поля формы или пустую строку
 * @param string $field Имя поля
 * @return string Экранированное значение поля
 */
function getFormValue(string $field): string {
    return htmlspecialchars($_POST[$field] ?? '');
}

/**
 * Проверяет, выбрано ли значение в выпадающем списке
 * @param string $field Имя поля
 * @param mixed $value Значение для проверки
 * @param bool $isArray Флаг, указывающий, является ли поле массивом
 * @return string 'selected' если значение выбрано, иначе пустая строка
 */
function isSelected(string $field, $value, bool $isArray = false): string {
    if ($isArray) {
        return in_array($value, $_POST[$field] ?? []) ? 'selected' : '';
    }
    return ($_POST[$field] ?? '') == $value ? 'selected' : '';
}