<?php

namespace App\Services\Fetcher\HTTP;

use App\Services\Writer\FileWriter;
use App\Services\Fetcher\FetcherInterface;
use App\Services\Writer\WriterInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HTTPFetcher implements FetcherInterface
{
    private HttpClientInterface $client;
    private array $options = [];
    private ?WriterInterface $writer;

    public function __construct(
        ParameterBagInterface $parameterBag,
        WriterInterface $writer = null,
        HttpClientInterface $client = null,
        int $timeout = 10
    )
    {
        $this->writer = $writer;
        if (null === $writer) {
            $path = $parameterBag->get('kernel.project_dir')  . '/tmp/' . md5((string)time());
            $this->writer = new FileWriter($path);
        }
        $this->client = ($client ?: new CurlHttpClient());
        $this->options = [
            'timeout' => $timeout,
            'headers' => [
            ],
        ];
    }

    public function fetch(string $url, int $chunksCount = -1): string
    {
        $this->writer->open();
        $response = $this->client->request('GET', $url, $this->options);

        $currentChunk = 0;
        foreach ($this->client->stream($response) as $chunk) {
            $this->writer->write($chunk->getContent());
            if ($chunksCount > 0 && $currentChunk >= $chunksCount) {
                break;
            }
            $currentChunk++;
        }
        $filePath = $this->writer->getPath();
        $this->writer->close();
        return $filePath;
    }
}
