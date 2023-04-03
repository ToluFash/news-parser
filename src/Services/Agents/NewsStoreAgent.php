<?php

namespace App\Services\Agents;

use App\Entity\News;
use App\Message\NewsStore;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class NewsStoreAgent
{
    private EntityManagerInterface $em;
    private LoggerInterface $logger;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger
    ) {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function evaluate(NewsStore $newsStore): void
    {

        if ($this->em->getRepository(News::class)->findOneBy(
            ['title' => $newsStore->getNews()->title]
        )) {
            return;
        }


        $this->em->persist($this->buildNews($newsStore->getNews()));
        $this->em->flush();
    }

    private function buildNews(object $newObject): News
    {
        $news = new News();
        $news->setAuthor($newObject->author);
        $news->setTitle($newObject->title);
        $news->setDescription($newObject->description);
        $news->setSource($newObject->source);
        $news->setCountry($newObject->country);
        $news->setLanguage($newObject->language);
        $news->setImage($newObject->image);
        $news->setPublishedAt(new \DateTimeImmutable($newObject->published_at));

        return $news;
    }
}
