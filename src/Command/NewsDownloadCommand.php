<?php

namespace App\Command;

use App\Services\Agents\NewsDownloadAgent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewsDownloadCommand extends Command
{
    protected static $defaultName = 'app:news-download';
    protected static $defaultDescription = 'Download News From API';

    private NewsDownloadAgent $newsDownloadAgent;

    public function __construct(NewsDownloadAgent $newsDownloadAgent)
    {
        parent::__construct();
        $this->newsDownloadAgent = $newsDownloadAgent;
    }

    protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->newsDownloadAgent->start();
        return Command::SUCCESS;

    }
}
