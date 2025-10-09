<?php

namespace Src\Validator;

class PasswordValidator
{
    protected string $password;
    protected array $errors = [];

    public function __construct(string $password)
    {
        $this->password = $password;
        $this->validate();
    }

    private function validate(): void
    {
        // Проверка на хотя бы одну букву
        if (!preg_match('/[A-Za-z]/', $this->password)) {
            $this->errors[] = 'Пароль должен содержать хотя бы одну букву';
        }

        // Проверка на хотя бы одну цифру
        if (!preg_match('/\d/', $this->password)) {
            $this->errors[] = 'Пароль должен содержать хотя бы одну цифру';
        }

        // Минимальная длина (например, 6)
        if (mb_strlen($this->password) < 6) {
            $this->errors[] = 'Пароль должен содержать минимум 6 символов';
        }
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
