<div class="department-wrapper">
    <h2 class="department-title">Добавить кафедру</h2>

    <?php if (!empty($message)) : ?>
        <div class="department-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>


    <form method="post" class="department-form">
        <!-- CSRF-токен -->
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <div class="form-group">
            <input
                    type="text"
                    name="name"
                    placeholder="Название кафедры"
                    value="<?= htmlspecialchars($old['name'] ?? '') ?>"
            >
            <?php if (!empty($errors['name'])): ?>
                <span class="error-text"><?= htmlspecialchars($errors['name'][0]) ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Добавить</button>
    </form>
</div>
