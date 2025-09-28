<div class="discipline-wrapper">
    <h2 class="discipline-title">Добавить дисциплину</h2>

    <?php if (!empty($message)) : ?>
        <div class="discipline-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="discipline-form">
        <!-- CSRF-токен -->
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <input type="text" name="name" placeholder="Название дисциплины" required>
        <button type="submit">Добавить</button>
    </form>
</div>
