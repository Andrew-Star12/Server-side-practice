<?php

namespace Src\Validator;

use Illuminate\Database\Capsule\Manager as DB;

class SimpleValidator
{
    private array $data;     // Данные формы
    private array $rules;    // Правила валидации
    private array $errors = []; // Ошибки

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->validate();
    }

    private function validate(): void
    {
        foreach ($this->rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $this->applyRule($field, $rule);
            }
        }
    }

    private function applyRule(string $field, string $rule): void
    {
        $value = $this->data[$field] ?? '';

        // not_empty
        if ($rule === 'not_empty' && trim($value) === '') {
            $this->errors[$field][] = "Поле '{$field}' не может быть пустым";
        }

        // min:3
        if (str_starts_with($rule, 'min:')) {
            $min = (int)substr($rule, 4);
            if (mb_strlen($value) < $min) {
                $this->errors[$field][] = "Поле '{$field}' должно содержать минимум {$min} символов";
            }
        }

        // unique:users,login
        if (str_starts_with($rule, 'unique:')) {
            $parts = explode(':', $rule)[1]; // users,login
            [$table, $column] = explode(',', $parts);
                    $exists = DB::table($table)->where($column, $value)->exists();
            if ($exists) {
                $this->errors[$field][] = "Поле '{$field}' должно быть уникальным";
            }
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
