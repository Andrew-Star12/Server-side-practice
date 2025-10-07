<div class="staff-wrapper">
    <h2 class="staff-title">Список сотрудников</h2>

    <!-- Форма фильтрации -->
    <form method="get" action="" class="filter-form">
        <label for="department">Фильтр по кафедре:</label>
        <select name="department_id" id="department">
            <option value="">-- Все кафедры --</option>
            <?php foreach ($departments as $dept): ?>
                <option value="<?= $dept->id ?>" <?= isset($selectedDepartment) && $selectedDepartment == $dept->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dept->name) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="search">Поиск:</label>
        <input type="text" name="search" id="search"
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
               placeholder="Фамилия, имя или должность">

        <button type="submit">Показать</button>
    </form>


    <!-- Таблица сотрудников -->
    <?php if (!empty($staff)): ?>
        <table class="staff-table">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Должность</th>
                <th>Кафедра</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($staff as $person): ?>
                <tr>
                    <td>
                        <?php if (!empty($person->photo)): ?>
                            <img src="/pop-it-mvc/<?= htmlspecialchars($person->photo) ?>" alt="Фото" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($person->lastname) ?></td>
                    <td><?= htmlspecialchars($person->firstname) ?></td>
                    <td><?= htmlspecialchars($person->middlename) ?></td>
                    <td><?= htmlspecialchars($person->position) ?></td>
                    <td><?= $person->department ? htmlspecialchars($person->department->name) : '—' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-staff">Сотрудники не найдены.</p>
    <?php endif; ?>
</div>
