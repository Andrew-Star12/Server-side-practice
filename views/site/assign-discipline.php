<div class="assign-wrapper">
    <h2 class="assign-title">Прикрепить сотрудника к дисциплине</h2>

    <?php if (!empty($message)) : ?>
        <div class="assign-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="assign-form">
        <!-- CSRF-токен -->
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <label for="staff_id">Сотрудник:</label>
        <select id="staff_id" name="staff_id" required>
            <option value="">Выберите сотрудника</option>
            <?php foreach ($staff as $s): ?>
                <option value="<?= $s->id ?>">
                    <?= htmlspecialchars($s->lastname . ' ' . $s->firstname . ' ' . $s->middlename) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="discipline_id">Дисциплина:</label>
        <select id="discipline_id" name="discipline_id" required>
            <option value="">Выберите дисциплину</option>
            <?php foreach ($disciplines as $d): ?>
                <option value="<?= $d->id ?>"><?= htmlspecialchars($d->name) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Прикрепить</button>
    </form>
</div>
