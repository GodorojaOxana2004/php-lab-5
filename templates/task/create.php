<?php
/**
 * Шаблон формы создания задачи
 * @var array $categories Список категорий
 * @var array $errors Ошибки валидации
 */
$title = 'Добавить задачу';
?>

<h1>Добавить задачу</h1>
<form method="POST" action="/task/create">
    <div>
        <label>Название:</label><br>
        <input type="text" name="title" value="<?= getFormValue('title') ?>">
        <?php if (isset($errors['title'])): ?>
            <p class="error"><?= htmlspecialchars($errors['title']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Категория:</label><br>
        <select name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= isSelected('category_id', $category['id']) ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['category_id'])): ?>
            <p class="error"><?= htmlspecialchars PHONE($errors['category_id']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Описание:</label><br>
        <textarea name="description"><?= getFormValue('description') ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <p class="error"><?= htmlspecialchars($errors['description']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Тэги:</label><br>
        <select name="tags[]" multiple>
            <option value="важно" <?= isSelected('tags', 'важно', true) ?>>Важно</option>
            <option value="быстро" <?= isSelected('tags', 'быстро', true) ?>>Быстро</option>
            <option value="сложно" <?= isSelected('tags', 'сложно', true) ?>>Сложно</option>
        </select>
    </div>

    <div>
        <label>Шаги:</label><br>
        <div id="steps">
            <div class="step">
                <textarea name="steps[]" rows="2"></textarea>
                <span class="remove-step">Удалить</span>
            </div>
        </div>
        <button type="button" id="add-step">Добавить шаг</button>
    </div>

    <button type="submit">Сохранить</button>
</form>