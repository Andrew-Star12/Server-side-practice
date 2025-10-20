<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../';

require_once __DIR__ . '/../vendor/autoload.php';

$GLOBALS['app'] = new Src\Application(new Src\Settings([
    'app'  => include $_SERVER['DOCUMENT_ROOT'] . '/config/app.php',

    // 👇 Подменяем обычную MySQL-конфигурацию на SQLite in-memory для тестов
    'db'   => [
        'driver'   => 'sqlite',
        'database' => 'mvc',
        'prefix'   => '',
    ],

    'path' => include $_SERVER['DOCUMENT_ROOT'] . '/config/path.php',
]));

if (!function_exists('app')) {
    function app() {
        return $GLOBALS['app'];
    }
}
