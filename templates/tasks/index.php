<?php
/**
 * Шаблон списка всех задач
 * @var array $tasks Список задач
 * @var int $page Текущая страница
 * @var int $totalPages Всего страниц
 */
$title = 'Все задачи';
?>

<h1>Все задачи</h1>
<?php if (empty($tasks)): ?>
    <p>Пока нет задач.</p>
<?php else: ?>
    <?php foreach ($tasks as $task): ?>
        <h2><?= htmlspecialchars($task['title']) ?></h2>
        <p>Категория: <?= htmlspecialchars($task['category_name']) ?></p>
        <p><?= htmlspecialchars($task['description']) ?></p>
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
        <p><a href="/task/show?id=<?= $task['id'] ?>">Подробнее</a></p>
        <hr>
    <?php endforeach; ?>

    <div>
        <?php if ($page > 1): ?>
            <a href="/tasks?page=<?= $page - 1 ?>">Назад</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
                <strong><?= $i ?></strong>
            <?php else: ?>
                <a href="/tasks?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
            <a href="/tasks?page=<?= $page + 1 ?>">Вперёд</a>
        <?php endif; ?>
    </div>
<?php endif; ?>