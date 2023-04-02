<?php


namespace App\Message;


use App\Entity\News;

class NewsStore
{

    private string $news;

    public function __construct(string $news)
    {
        $this->news = $news;
    }

    /**
     * @return object
     */
    public function getNews(): object
    {
        return json_decode($this->news);
    }
}
