<div class="discipline-wrapper">
    <h2 class="discipline-title">Добавить дисциплину</h2>

    <?php if (!empty($message)) : ?>
        <div class="discipline-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="discipline-form">
        <!-- CSRF-токен -->
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <div class="form-group">
            <input
                    type="text"
                    name="name"
                    placeholder="Название дисциплины"
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
            >
            <?php if (!empty($errors['name'])): ?>
                <span class="error-text"><?= htmlspecialchars($errors['name'][0]) ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Добавить</button>
    </form>
</div>
