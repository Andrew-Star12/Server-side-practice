<?php
return [
//Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
//Клас пользователя
    'identity' => \Model\User::class,
//Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'role' => \Middlewares\RoleMiddleware::class,
    ],
    'validators' => [

    ],
    'routeAppMiddleware' => [
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'csrf' => \Middlewares\CSRFMiddleware::class,
    ],

];