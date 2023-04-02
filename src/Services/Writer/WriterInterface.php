<?php

namespace App\Services\Writer;

interface WriterInterface extends FileInterface
{
    public function write(string $data): int;
}
