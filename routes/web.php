<?php
use Src\Route;

// ==============================
// Общедоступные (требуется авторизация)
// ==============================
Route::add('GET', '/hello', [Controller\SiteController::class, 'hello'])
    ->middleware('auth');

// ==============================
// Аутентификация
// ==============================
Route::add(['GET', 'POST'], '/signup', [Controller\AuthController::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\AuthController::class, 'login']);
Route::add('GET', '/logout', [Controller\AuthController::class, 'logout']);

// ==============================
// ADMIN
// ==============================
Route::add(['GET', 'POST'], '/deanstaff/add', [Controller\AuthController::class, 'addDeanStaff'])
    ->middleware('auth', 'role:admin');

// ==============================
// DEAN_STAFF + ADMIN
// ==============================
Route::add(['GET', 'POST'], '/staff/add', [Controller\StaffController::class, 'addStaff'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add(['GET', 'POST'], '/staff/edit/{id}', [Controller\StaffController::class, 'editStaff'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add(['GET', 'POST'], '/department/add', [Controller\DepartmentController::class, 'addDepartment'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add(['GET', 'POST'], '/discipline/add', [Controller\DisciplineController::class, 'addDiscipline'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add(['GET', 'POST'], '/assign-discipline', [Controller\DisciplineController::class, 'assignDiscipline'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add('GET', '/staff/list', [Controller\StaffController::class, 'listStaff'])
    ->middleware('auth', 'role:admin,dean_staff');

Route::add('GET', '/discipline/list', [Controller\DisciplineController::class, 'listDisciplines'])
    ->middleware('auth', 'role:admin,dean_staff');
