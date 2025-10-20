<?php
namespace Controller;

use Src\View;
use Model\User;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\SimpleValidator;
use Src\Validator\PasswordValidator;

class AuthController
{
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            $validator = new SimpleValidator($data, [
                'name'     => ['not_empty'],
                'login'    => ['not_empty', 'unique:users,login'],
                'password' => ['not_empty'],
            ]);

            $passwordValidator = new PasswordValidator($data['password'] ?? '');

            if ($validator->fails() || $passwordValidator->fails()) {
                $errors = $validator->errors();
                if ($passwordValidator->fails()) {
                    $errors['password'] = array_merge($errors['password'] ?? [], $passwordValidator->errors());
                }

                return new View('site.signup', [
                    'errors' => $errors,
                    'old'    => $data
                ]);
            }

            $data['password'] = md5($data['password']);
            if (User::create($data)) {
                app()->route->redirect('/login');
                return '';
            }
        }

        return new View('site.signup');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        $data = $request->all();

        $validator = new SimpleValidator($data, [
            'login'    => ['not_empty'],
            'password' => ['not_empty']
        ]);

        if ($validator->fails()) {
            return new View('site.login', [
                'errors' => $validator->errors(),
                'old'    => $data
            ]);
        }

        if (Auth::attempt($data)) {
            app()->route->redirect('/hello');
        }

        return new View('site.login', [
            'message' => 'Неправильные логин или пароль',
            'old'     => $data
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function addDeanStaff(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            $validator = new SimpleValidator($data, [
                'name'     => ['not_empty'],
                'login'    => ['not_empty', 'unique:users,login'],
                'password' => ['not_empty', 'min:6'],
            ]);

            if ($validator->fails()) {
                return new View('site.deanstaff-add', [
                    'errors' => $validator->errors(),
                    'old'    => $data
                ]);
            }

            $data['role'] = 'dean_staff';
            $data['password'] = md5($data['password']);

            if (User::create($data)) {
                return new View('site.deanstaff-add', [
                    'message' => 'Сотрудник деканата успешно добавлен'
                ]);
            }

            return new View('site.deanstaff-add', [
                'message' => 'Ошибка при добавлении сотрудника'
            ]);
        }

        return new View('site.deanstaff-add');
    }
}
