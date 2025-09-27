<?php
use Src\Route;

// Доступен всем залогиненным
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');

// Регистрация и вход доступны всем
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);


// =========================
// Роуты только для ADMIN
// =========================
Route::add(['GET', 'POST'], '/deanstaff/add', [Controller\Site::class, 'addDeanStaff'])
    ->middleware('auth', 'role:admin');

// ==============================
// Роуты только для DEAN_STAFF + ADMIN
// ==============================
Route::add(['GET', 'POST'], '/staff/add', [Controller\Site::class, 'addStaff'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add(['GET', 'POST'], '/department/add', [Controller\Site::class, 'addDepartment'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add(['GET', 'POST'], '/discipline/add', [Controller\Site::class, 'addDiscipline'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add(['GET', 'POST'], '/assign-discipline', [Controller\Site::class, 'assignDiscipline'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add('GET', '/staff/list', [Controller\Site::class, 'listStaff'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add('GET', '/discipline/list', [Controller\Site::class, 'listDisciplines'])
    ->middleware('auth', 'role:admin,dean_staff');


