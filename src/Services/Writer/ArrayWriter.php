<?php

namespace App\Services\Writer;

class ArrayWriter implements WriterInterface
{
    private bool $isOpen = false;
    private string $data;

    public function open(): bool
    {
        $this->data = '';
        $this->isOpen = true;
        return true;
    }

    public function write(string $data): int
    {
        $this->data .= $data;
        return mb_strlen($data);
    }

    public function read(): string
    {
        return $this->data;
    }

    public function close(): bool
    {
        $this->isOpen = false;
        return true;
    }

    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    public function getPath(): string
    {
        return '';
    }
}
