<h2>Прикрепить сотрудника к дисциплине</h2>

<?php if (!empty($message)) : ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form method="post">
    <label>Сотрудник:</label><br>
    <select name="staff_id" required>
        <option value="">Выберите сотрудника</option>
        <?php foreach ($staff as $s): ?>
            <option value="<?= $s->id ?>">
                <?= $s->lastname ?> <?= $s->firstname ?> <?= $s->middlename ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Дисциплина:</label><br>
    <select name="discipline_id" required>
        <option value="">Выберите дисциплину</option>
        <?php foreach ($disciplines as $d): ?>
            <option value="<?= $d->id ?>"><?= $d->name ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Прикрепить</button>
</form>
