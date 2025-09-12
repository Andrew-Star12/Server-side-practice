<?php
use Src\Route;
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class,
    'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class,
    'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add(['GET', 'POST'], '/staff/add', [Controller\Site::class, 'addStaff'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/department/add', [Controller\Site::class, 'addDepartment'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/discipline/add', [Controller\Site::class, 'addDiscipline'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/assign-discipline', [Controller\Site::class, 'assignDiscipline'])
    ->middleware('auth');
Route::add('GET', '/staff/list', [Controller\Site::class, 'listStaff'])
    ->middleware('auth');