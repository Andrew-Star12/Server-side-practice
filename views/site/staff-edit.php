<div class="staff-edit-wrapper">
    <h2 class="staff-edit-title">Редактирование сотрудника</h2>

    <?php if (!empty($message)): ?>
        <div class="staff-add-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="staff-edit-form">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <div class="form-group">
            <label>Фамилия:</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($staff->lastname ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Имя:</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($staff->firstname ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Отчество:</label>
            <input type="text" name="middlename" value="<?= htmlspecialchars($staff->middlename ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Пол:</label>
            <select name="gender">
                <option value="male" <?= ($staff->gender ?? '') === 'male' ? 'selected' : '' ?>>Мужской</option>
                <option value="female" <?= ($staff->gender ?? '') === 'female' ? 'selected' : '' ?>>Женский</option>
            </select>
        </div>

        <div class="form-group">
            <label>Дата рождения:</label>
            <input type="date" name="birthdate" value="<?= htmlspecialchars($staff->birthdate ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Должность:</label>
            <input type="text" name="position" value="<?= htmlspecialchars($staff->position ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Кафедра:</label>
            <select name="department_id">
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept->id ?>" <?= ($staff->department_id ?? null) == $dept->id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Фото:</label>
            <?php if (!empty($staff->photo)): ?>
                <div class="photo-preview">
                    <img src="/<?= htmlspecialchars($staff->photo) ?>" alt="Фото">
                </div>
            <?php endif; ?>
            <input type="file" name="photo">
        </div>

        <button type="submit">Сохранить</button>
    </form>
</div>
