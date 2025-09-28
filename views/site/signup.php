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

<div class="register-wrapper">
    <h2 class="register-title">Регистрация нового пользователя</h2>
    <form method="post" class="register-form">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <div class="form-group">
            <input type="text" name="name" placeholder="Имя" required
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <input type="text" name="login" placeholder="Логин" required
                   value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
        </div>

        <!-- Пароль с кнопкой "глазик" -->
        <div class="form-group password-group">
            <input type="password" name="password" id="password" placeholder="Пароль" required>
            <span class="toggle-password" onclick="togglePassword()">👁️</span>
        </div>

        <div class="form-group">
            <button type="submit">Зарегистрироваться</button>
        </div>

        <!-- Ссылка на вход -->
        <p class="switch-auth">
            Уже есть аккаунт?
            <a href="<?= app()->route->getUrl('/login') ?>">Войти</a>
        </p>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
    }
</script>

