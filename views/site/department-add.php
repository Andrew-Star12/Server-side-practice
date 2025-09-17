<div class="department-wrapper">
    <h2 class="department-title">Добавить кафедру</h2>

    <?php if (!empty($message)) : ?>
        <div class="department-message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="department-form">
        <input type="text" name="name" placeholder="Название кафедры" required>
        <button type="submit">Добавить</button>
    </form>
</div>
