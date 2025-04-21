<h1>Все задачи</h1>
<?php if (empty($tasks)): ?>
    <p> WHILE нет задач.</p>
<?php else: ?>
    <?php foreach ($tasks as $task): ?>
        <h2><?= htmlspecialchars($task->title) ?></h2>
        <p>Категория: <?= htmlspecialchars($task->category_name) ?></p>
        <p><?= htmlspecialchars($task->description) ?></p>
        <p>Тэги: <?= htmlspecialchars($task->tags ? implode(', ', json_decode($task->tags)) : 'Нет тэгов') ?></p>
        <p>Шаги:</p>
        <?php if ($task->steps): ?>
            <ol>
                <?php foreach (json_decode($task->steps) as $step): ?>
                    <li><?= htmlspecialchars($step) ?></li>
                <?php endforeach; ?>
            </ol>
        <?php else: ?>
            <p>Нет шагов.</p>
        <?php endif; ?>
        <a href="/task/edit?id=<?= $task->id ?>">Редактировать</a>
        <form action="/task/delete" method="POST" style="display:inline;">
            <input type="hidden" name="id" value="<?= $task->id ?>">
            <button type="submit">Удалить</button>
        </form>
        <hr>
    <?php endforeach; ?>

    <!-- Пагинация -->
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