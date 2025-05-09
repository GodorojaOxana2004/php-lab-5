<h1>Редактировать задачу</h1>
<form method="POST" action="/task/edit?id=<?= $task->id ?>">
    <div>
        <label>Название:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($task->title) ?>">
        <?php if (isset($errors['title'])): ?>
            <p class="error"><?= $errors['title'] ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Категория:</label><br>
        <select name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= $task->category_id == $category->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['category_id'])): ?>
            <p class="error"><?= $errors['category_id'] ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Описание:</label><br>
        <textarea name="description"><?= htmlspecialchars($task->description) ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <p class="error"><?= $errors['description'] ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label>Тэги:</label><br>
        <select name="tags[]" multiple>
            <?php $taskTags = json_decode($task->tags) ?: []; ?>
            <option value="важно" <?= in_array('важно', $taskTags) ? 'selected' : '' ?>>Важно</option>
            <option value="быстро" <?= in_array('быстро', $taskTags) ? 'selected' : '' ?>>Быстро</option>
            <option value="сложно" <?= in_array('сложно', $taskTags) ? 'selected' : '' ?>>Сложно</option>
        </select>
    </div>

    <div>
        <label>Шаги:</label><br>
        <div id="steps">
            <?php foreach (json_decode($task->steps) ?: [] as $step): ?>
                <div class="step">
                    <textarea name="steps[]" rows="2"><?= htmlspecialchars($step) ?></textarea>
                    <span class="remove-step">Удалить</span>
                </div>
            <?php endforeach; ?>
            <?php if (empty(json_decode($task->steps))): ?>
                <div class="step">
                    <textarea name="steps[]" rows="2"></textarea>
                    <span class="remove-step">Удалить</span>
                </div>
            <?php endif; ?>
        </div>
        <button type="button" id="add-step">Добавить шаг</button>
    </div>

    <button type="submit">Сохранить</button>
</form>