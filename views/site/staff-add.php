<div class="employee-wrapper">
    <h2 class="employee-title">Добавить нового сотрудника</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-block" style="color:red;">
            <ul>
                <?php foreach ($errors as $fieldErrors): ?>
                    <?php foreach ($fieldErrors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <form method="post" enctype="multipart/form-data" class="employee-form">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <div class="form-group">
            <input type="text" name="lastname" placeholder="Фамилия" >
        </div>

        <div class="form-group">
            <input type="text" name="firstname" placeholder="Имя" >
        </div>

        <div class="form-group">
            <input type="text" name="middlename" placeholder="Отчество">
        </div>

        <div class="form-group">
            <select name="gender" >
                <option value="">Пол</option>
                <option value="male">Мужской</option>
                <option value="female">Женский</option>
            </select>
        </div>

        <div class="form-group">
            <input type="date" name="birthdate" >
        </div>

        <div class="form-group">
            <input type="text" name="address" placeholder="Адрес">
        </div>

        <div class="form-group">
            <input type="text" name="position" placeholder="Должность" >
        </div>

        <div class="form-group">
            <select name="department_id" >
                <option value="">Выберите кафедру</option>
                <?php foreach ($departments as $department): ?>
                    <option value="<?= $department->id ?>"><?= htmlspecialchars($department->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Фото:</label>
            <input type="file" name="photo" accept="image/*">
        </div>

        <button type="submit">Добавить</button>
    </form>
</div>
