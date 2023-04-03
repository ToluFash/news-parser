<?php

namespace App\Services\Agents;

use App\Message\NewsProcess;
use App\Message\NewsStore;
use JsonMachine\Items;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class NewsProcessAgent
{
    private MessageBusInterface $bus;
    private LoggerInterface $logger;

    public function __construct(
        MessageBusInterface $bus,
        LoggerInterface $logger
    ) {
        $this->bus = $bus;
        $this->logger = $logger;
    }

    public function evaluate(NewsProcess $process)
    {
        $this->logger->info(sprintf('Processing News @ %s', (new \DateTime())->format(\DateTimeInterface::ATOM)));
        $newsItems = Items::fromFile($process->getFilePath(), ['pointer' => '/data']);

        foreach ($newsItems as $news) {
            $this->bus->dispatch(new NewsStore(json_encode($news)));
        }

        $this->logger->info(sprintf('Processing for News @ %s successful', (new \DateTime())->format(\DateTimeInterface::ATOM)));
    }
}
