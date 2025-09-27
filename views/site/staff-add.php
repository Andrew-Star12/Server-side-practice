<div class="employee-wrapper">
    <h2 class="employee-title">Добавить нового сотрудника</h2>

    <form method="post" class="employee-form">
        <div class="form-group">
            <input type="text" name="lastname" placeholder="Фамилия" required>
        </div>

        <div class="form-group">
            <input type="text" name="firstname" placeholder="Имя" required>
        </div>

        <div class="form-group">
            <input type="text" name="middlename" placeholder="Отчество">
        </div>

        <div class="form-group">
            <select name="gender" required>
                <option value="">Пол</option>
                <option value="male">Мужской</option>
                <option value="female">Женский</option>
            </select>
        </div>

        <div class="form-group">
            <input type="date" name="birthdate" required>
        </div>

        <div class="form-group">
            <input type="text" name="address" placeholder="Адрес">
        </div>

        <div class="form-group">
            <input type="text" name="position" placeholder="Должность" required>
        </div>

        <div class="form-group">
            <select name="department_id" required>
                <option value="">Выберите кафедру</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?= $department->id ?>"><?= htmlspecialchars($department->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Добавить</button>
    </form>
</div>
