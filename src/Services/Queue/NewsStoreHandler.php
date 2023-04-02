<?php

namespace App\Services\Queue;

use App\Message\NewsStore;
use App\Services\Agents\NewsStoreAgent;

class NewsStoreHandler
{
    private NewsStoreAgent $newsStoreAgent;

    public function __construct(NewsStoreAgent $newsStoreAgent)
    {
        $this->newsStoreAgent = $newsStoreAgent;
    }


    public function __invoke(NewsStore $newsStore)
    {
        $this->newsStoreAgent->evaluate($newsStore);
    }

}
