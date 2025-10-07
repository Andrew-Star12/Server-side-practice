<?php if (!app()->auth::check()): ?>
    <div class="auth-container">

        <form method="post" class="auth-form">
            <h2 class="auth-title">Авторизация</h2>

            <!-- Блок ошибок -->
            <?php if (!empty($errors)): ?>
                <div class="form-errors">
                    <ul>
                        <?php foreach ($errors as $fieldErrors): ?>
                            <?php foreach ($fieldErrors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Блок сообщения -->
            <?php if (!empty($message)): ?>
                <div class="auth-message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

            <label>
                Логин
                <input type="text" name="login"
                       value="<?= htmlspecialchars($old['login'] ?? '') ?>">
            </label>

            <label>
                Пароль
                <input type="password" name="password">
            </label>

            <button type="submit">Войти</button>
        </form>
    </div>
<?php else: ?>
    <p class="auth-welcome">
        Вы вошли как <strong><?= htmlspecialchars(app()->auth->user()->name) ?></strong>
    </p>
<?php endif; ?>
