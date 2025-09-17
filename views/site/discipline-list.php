<div class="disciplines-wrapper">
    <h2 class="disciplines-title">Список дисциплин</h2>

    <form method="get" action="" class="filter-form">
        <label for="department">Фильтр по кафедре:</label>
        <select name="department_id" id="department">
            <option value="">Все кафедры</option>
            <?php foreach ($departments as $department): ?>
                <option value="<?= $department->id ?>" <?= ($selectedDepartmentId == $department->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($department->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Показать</button>
    </form>

    <?php if (!empty($disciplines)): ?>
        <table class="disciplines-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название дисциплины</th>
                <th>Преподаватели</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($disciplines as $discipline): ?>
                <tr>
                    <td><?= htmlspecialchars($discipline->id) ?></td>
                    <td><?= htmlspecialchars($discipline->name) ?></td>
                    <td>
                        <?php foreach ($discipline->staff as $staff): ?>
                            <?php if (!$selectedDepartmentId || $staff->department_id == $selectedDepartmentId): ?>
                                <?= htmlspecialchars($staff->lastname . ' ' . $staff->firstname) ?><br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-disciplines">Дисциплины не найдены.</p>
    <?php endif; ?>
</div>
