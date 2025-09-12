<h2>Добавить нового сотрудника</h2>

<?php


use Model\Department;

$departments = Department::all();
?>

<form method="post">
    <input type="text" name="lastname" placeholder="Фамилия" required><br>
    <input type="text" name="firstname" placeholder="Имя" required><br>
    <input type="text" name="middlename" placeholder="Отчество"><br>
    <select name="gender" required>
        <option value="">Пол</option>
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
    </select><br>
    <input type="date" name="birthdate" placeholder="Дата рождения" required><br>
    <input type="text" name="address" placeholder="Адрес"><br>
    <input type="text" name="position" placeholder="Должность" required><br>
    <select name="department_id" required>
        <option value="">Выберите кафедру</option>
        <?php foreach ($departments as $department): ?>
            <option value="<?= $department->id ?>"><?= htmlspecialchars($department->name) ?></option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit">Добавить</button>
</form>
