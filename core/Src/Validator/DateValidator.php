<?php

namespace Src\Validator;

class DateValidator
{
    private string $date;
    private array $errors = [];

    public function __construct(string $date)
    {
        $this->date = $date;
        $this->validate();
    }

    private function validate(): void
    {
        // Проверяем формат даты (YYYY-MM-DD)
        $d = \DateTime::createFromFormat('Y-m-d', $this->date);
        $isValidFormat = $d && $d->format('Y-m-d') === $this->date;

        if (!$isValidFormat) {
            $this->errors[] = 'Некорректный формат даты';
            return;
        }

        // Проверяем, что дата не в будущем
        $now = new \DateTime();
        if ($d > $now) {
            $this->errors[] = 'Дата не может быть в будущем';
        }

        // Можно также добавить проверку минимального возраста
        $minAge = 16;
        $diff = $d->diff($now);
        if ($diff->y < $minAge) {
            $this->errors[] = "Возраст должен быть не менее {$minAge} лет";
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