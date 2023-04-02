<?php

namespace App\Services\Fetcher;

interface FetcherInterface
{
    public function fetch(string $url, int $chunksCount = -1): string;
}
