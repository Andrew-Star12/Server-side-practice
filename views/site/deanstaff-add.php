<div class="staff-add-wrapper">
    <h2 class="staff-add-title">Добавление сотрудника деканата</h2>

    <?php if (!empty($message)): ?>
        <div class="staff-add-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="staff-add-form">
        <!-- CSRF-токен -->
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <label for="name">Имя:</label>
        <input id="name" type="text" name="name" required>

        <label for="login">Логин:</label>
        <input id="login" type="text" name="login" required>

        <label for="password">Пароль:</label>
        <input id="password" type="password" name="password" required>

        <button type="submit">Добавить</button>
    </form>
</div>
