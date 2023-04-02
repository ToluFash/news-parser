<?php

namespace App\Services\Queue;

use App\Message\NewsProcess;
use App\Services\Agents\NewsProcessAgent;

class NewsProcessHandler
{
    private NewsProcessAgent $newsProcessAgent;

    public function __construct(NewsProcessAgent $newsProcessAgent)
    {
        $this->newsProcessAgent = $newsProcessAgent;
    }


    public function __invoke(NewsProcess $newsProcess)
    {
        $this->newsProcessAgent->evaluate($newsProcess);
    }

}
