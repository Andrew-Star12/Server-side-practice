<div class="staff-add-wrapper">
    <h2 class="staff-add-title">Добавление сотрудника деканата</h2>

    <?php if (!empty($message)): ?>
        <div class="staff-add-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="staff-add-form">
        <!-- CSRF-токен -->
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <div class="form-group">
            <label for="name">Имя:</label>
            <input id="name" type="text" name="name" placeholder="Введите имя" >
            <?php if (!empty($errors['name'])): ?>
                <span class="error-text"><?= htmlspecialchars($errors['name'][0]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="login">Логин:</label>
            <input id="login" type="text" name="login" placeholder="Введите логин" >
            <?php if (!empty($errors['login'])): ?>
                <span class="error-text"><?= htmlspecialchars($errors['login'][0]) ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" >
            <?php if (!empty($errors['password'])): ?>
                <span class="error-text"><?= htmlspecialchars($errors['password'][0]) ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Добавить сотрудника</button>
    </form>
</div>
