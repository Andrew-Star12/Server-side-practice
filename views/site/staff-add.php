<div class="employee-wrapper">
    <h2 class="employee-title">Добавить нового сотрудника</h2>

    <form method="post" class="employee-form">
        <input type="text" name="lastname" placeholder="Фамилия" required>
        <input type="text" name="firstname" placeholder="Имя" required>
        <input type="text" name="middlename" placeholder="Отчество">

        <select name="gender" required>
            <option value="">Пол</option>
            <option value="male">Мужской</option>
            <option value="female">Женский</option>
        </select>

        <input type="date" name="birthdate" placeholder="Дата рождения" required>
        <input type="text" name="address" placeholder="Адрес">
        <input type="text" name="position" placeholder="Должность" required>

        <select name="department_id" required>
            <option value="">Выберите кафедру</option>
            <?php foreach ($departments as $department): ?>
                <option value="<?= $department->id ?>"><?= htmlspecialchars($department->name) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Добавить</button>
    </form>
</div>
