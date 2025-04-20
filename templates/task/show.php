<?php
/**
 * Шаблон просмотра задачи
 * @var array $task Данные задачи
 */
$title = htmlspecialchars($task['title']);
?>

<h1><?= htmlspecialchars($task['title']) ?></h1>
<p>Категория: <?= htmlspecialchars($task['category_name']) ?></p>
<p>Описание: <?= htmlspecialchars($task['description']) ?></p>
<p>Тэги: <?= htmlspecialchars($task['tags'] ?? '') ?></p>
<p>Шаги:</p>
<?php if (!empty($task['steps'])): ?>
    <ol>
        <?php foreach (explode("\n", $task['steps']) as $step): ?>
            <li><?= htmlspecialchars($step) ?></li>
        <?php endforeach; ?>
    </ol>
<?php else: ?>
    <p>Нет шагов.</p>
<?php endif; ?>
<p>
    <a href="/task/edit?id=<?= $task['id'] ?>">Редактировать</a> |
    <a href="/task/delete?id=<?= $task['id'] ?>" onclick="return confirm('Удалить задачу?')">Удалить</a>
</p>