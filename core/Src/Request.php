<?php
namespace Src;

use Error;
use Model\User;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;
    public ?User $user = null; // добавляем свойство для текущего пользователя

    public function __construct()
    {
        $this->body = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders() ?? [];

        // Проверяем токен Bearer из заголовков
        if (isset($this->headers['Authorization'])) {
            $authHeader = $this->headers['Authorization'];
            if (strpos($authHeader, 'Bearer ') === 0) {
                $token = substr($authHeader, 7);
                $this->user = User::where('api_token', $token)->first();
            }
        }
    }

    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function set($field, $value): void
    {
        $this->body[$field] = $value;
    }

    public function get($field, $default = null)
    {
        return $this->body[$field] ?? $default;
    }

    public function files(): array
    {
        return $_FILES;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->body)) {
            return $this->body[$key];
        }

        if ($key === 'user') {
            return $this->user;
        }

        throw new Error('Accessing a non-existent property');
    }
}
