<?php

namespace App\Services\Agents;

use App\Message\NewsProcess;
use App\Services\Fetcher\HTTP\HTTPFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class NewsDownloadAgent
{
    private MessageBusInterface $bus;
    private LoggerInterface $logger;
    private ParameterBagInterface $parameterBag;
    private string $apiUrl;
    private string $apiAccessKey;

    public function __construct(
        MessageBusInterface $bus,
        LoggerInterface $logger,
        ParameterBagInterface $parameterBag,
        string $apiUrl,
        string $apiAccessKey
    ) {
        $this->bus = $bus;
        $this->logger = $logger;
        $this->parameterBag = $parameterBag;
        $this->apiUrl = $apiUrl;
        $this->apiAccessKey = $apiAccessKey;
    }

    public function start()
    {
        $this->logger->info(sprintf('Fetching News @ %s', (new \DateTime())->format(\DateTimeInterface::ATOM)));
        try {
            $fetcher = new HTTPFetcher($this->parameterBag);
            $newsFilePath = $fetcher->fetch($this->apiUrl.$this->apiAccessKey);
            $this->bus->dispatch(new NewsProcess($newsFilePath));
            $this->logger->info(sprintf('Download for News @ %s', (new \DateTime())->format(\DateTimeInterface::ATOM)));
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->logger->error(sprintf('Download for News failed @ %s', (new \DateTime())->format(\DateTimeInterface::ATOM)));
        }
    }
}
