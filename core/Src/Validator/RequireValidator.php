<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class RequireValidator extends AbstractValidator
{
    protected string $message = 'Поле :field обязательно для заполнения';

    public function rule(): bool
    {
        // Проверяем, что значение существует и не является пустой строкой
        return isset($this->value) && trim((string)$this->value) !== '';
    }
}
