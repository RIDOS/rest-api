<?php

namespace App\Controller;
use App\Repository\NewsRepository;

header('Content-Type: application/json');

class NewsController
{
    public function index(): string
    {
        $news = (new NewsRepository())->getNews();

        return json_encode($news);
    }

    public function getOne(int $id): string
    {
        $news = (new NewsRepository())->getNewsById($id);

        return json_encode($news);
    }
}