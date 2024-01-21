<?php

namespace App\Controller;
use App\Controller;
use App\Repository\NewsRepository;

class NewsController implements Controller
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
