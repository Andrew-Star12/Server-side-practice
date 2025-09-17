<?php if (!empty($message)): ?>
    <div class="auth-message"><?= $message ?></div>
<?php endif; ?>

<?php if (!app()->auth::check()): ?>
    <form method="post" class="auth-form">
        <h2 class="auth-title">Авторизация</h2>
        <label>
            Логин
            <input type="text" name="login" required>
        </label>
        <label>
            Пароль
            <input type="password" name="password" required>
        </label>
        <button type="submit">Войти</button>
    </form>
<?php else: ?>
    <p class="auth-welcome">Вы вошли как <strong><?= app()->auth->user()->name ?></strong></p>
<?php endif; ?>
