<?php

namespace Src\Validator;

class ImageValidator
{
    private array $file;
    private array $errors = [];

    private array $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private int $maxSize = 5 * 1024 * 1024; // 5 MB

    public function __construct(array $file)
    {
        $this->file = $file;
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = 'Ошибка при загрузке файла';
            return;
        }

        $type = mime_content_type($this->file['tmp_name']);
        if (!in_array($type, $this->allowedTypes, true)) {
            $this->errors[] = 'Неверный формат файла. Разрешены: JPG, PNG, GIF, WEBP';
        }

        if ($this->file['size'] > $this->maxSize) {
            $this->errors[] = 'Файл слишком большой. Максимум 5 МБ';
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
