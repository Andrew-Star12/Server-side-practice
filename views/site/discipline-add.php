<h2>Добавить дисциплину</h2>

<?php if (!empty($message)) : ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form method="post">
    <input type="text" name="name" placeholder="Название дисциплины" required><br>
    <button type="submit">Добавить</button>
</form>