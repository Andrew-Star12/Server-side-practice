<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/pop-it-mvc/public/css/style.css">
    <title>Pop it MVC</title>
    <style>
        /* Базовая стилизация */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            padding: 10px 20px;
        }

        nav {
            display: flex;
            gap: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        main {
            padding: 20px;
        }

        .button {
            display: inline-block;
            margin: 5px 10px 5px 0;
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .user-info {
            margin-left: auto;
            color: #ecf0f1;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>

        <?php if (!app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
        <?php else: ?>
            <?php
            $user = app()->auth::user();
            ?>
            <?php if ($user->isAdmin()): ?>
                <a href="<?= app()->route->getUrl('/deanstaff/add') ?>">Добавить сотрудника деканата</a>
            <?php endif; ?>

            <?php if ($user->isDeanStaff() || $user->isAdmin()): ?>
                <a href="<?= app()->route->getUrl('/staff/add') ?>">Добавить сотрудника</a>
                <a href="<?= app()->route->getUrl('/department/add') ?>">Добавить кафедру</a>
                <a href="<?= app()->route->getUrl('/discipline/add') ?>">Добавить дисциплину</a>
                <a href="<?= app()->route->getUrl('/assign-discipline') ?>">Прикрепить дисциплину</a>
                <a href="<?= app()->route->getUrl('/staff/list') ?>">Список сотрудников</a>
                <a href="<?= app()->route->getUrl('/discipline/list') ?>">Список дисциплин</a>
            <?php endif; ?>

            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= $user->name ?>)</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?= $content ?? '' ?>
</main>
</body>
</html>
