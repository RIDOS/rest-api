<?php

namespace App\Repository;

use App\DataBase;
use App\Entity\News;

class NewsRepository
{
    use DataBase;

    public function getNews(): array
    {
        return self::query('SELECT * FROM News');
    }

    public function getNewsById(int $id): array
    {
        return self::query("
            SELECT * 
            FROM News 
            WHERE id = $id;
        ");
    }


    public function addNews(News $news): array
    {
        $title = $news->getTitle();
        $body = $news->getBody();
        $dateCreate = (string) $news->getDateCreate();

        return self::query("
            INSET INTO News (title, body, date_create)
            VALUES (`$title`, `$body`, `$dateCreate`);
        ");
    }

    public function updateNews(News $news): array
    {
        $id = $news->getId();

        return self::query("
            UPDATE News
            SET
            WHERE id = '$id'
        ");
    }
}