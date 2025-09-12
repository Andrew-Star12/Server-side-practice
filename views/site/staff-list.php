<h2>Список сотрудников</h2>

<table border="1" cellpadding="5">
    <thead>
    <tr>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Должность</th>
        <th>Кафедра</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($staff as $person): ?>
        <tr>
            <td><?= htmlspecialchars($person->lastname) ?></td>
            <td><?= htmlspecialchars($person->firstname) ?></td>
            <td><?= htmlspecialchars($person->position) ?></td>
            <td>
                <?= $person->department ? htmlspecialchars($person->department->name) : '—' ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
