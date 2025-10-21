<?php
namespace Controller;

use Src\Request;
use Src\View;
use Model\User;

class Api
{
    public function index(): void
    {
        $posts = \Model\Post::all()->toArray();
        (new View())->toJSON($posts);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    // вторизация и выдача API токена
    public function login(Request $request): void
    {
        $data = $request->all();
        $login = $data['login'] ?? '';
        $password = $data['password'] ?? '';

        // Ищем пользователя по логину
        $user = User::where('login', $login)
            ->where('password', md5($password)) // если у тебя пароль хэшируется через md5
            ->first();

        if (!$user) {
            http_response_code(401);
            (new View())->toJSON(['error' => 'Неверный логин или пароль']);
            return;
        }

        // Генерируем токен (уникальный)
        $token = bin2hex(random_bytes(32));
        $user->api_token = $token;
        $user->save();

        (new View())->toJSON([
            'token' => $token,
            'user'  => [
                'id'    => $user->id,
                'login' => $user->login,
                'role'  => $user->role ?? null
            ]
        ]);
    }
    public function staffList(Request $request): void
    {
        $user = $request->user; // Пользователь из middleware

        // показываем всех сотрудников
        $staff = \Model\Staff::with('department')->get()->toArray();

        (new View())->toJSON([
            'authorized_user' => [
                'id' => $user->id,
                'login' => $user->login,
                'role' => $user->role,
            ],
            'staff' => $staff
        ]);
    }

}
