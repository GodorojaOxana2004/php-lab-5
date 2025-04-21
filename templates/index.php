<h1>Последние задачи</h1>
<?php if (empty($tasks)): ?>
    <p>Пока нет задач.</p>
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
        <hr>
    <?php endforeach; ?>
<?php endif; ?>