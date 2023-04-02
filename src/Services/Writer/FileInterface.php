<?php

namespace App\Services\Writer;

interface FileInterface
{
    public function open(): bool;
    public function close(): bool;
    public function isOpen(): bool;
    public function getPath(): string;
}
