<?php
namespace Middlewares;

use Src\Request;
use Model\User;

class ApiAuthMiddleware
{
    public function handle(Request $request, $next)
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (!$authHeader || !preg_match('/Bearer\s+(\S+)/', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(['error' => 'Необходим токен']);
            return;
        }

        $token = $matches[1];

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Неверный токен']);
            return;
        }

        // добавим объект пользователя в запрос
        $request->user = $user;

        return $next($request);
    }
}
