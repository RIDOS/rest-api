<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;

/**
 * Контроллер Новостей.
 * 
 * Данный контроллер выполяет полсный CRUD с таблице News.
 * Используется в index, для работы с RESTfull.
 * 
 * @author a.imaev <smartsites.dev27@gmail.com>
 */
class NewsController
{
    /**
     * Вывод всех новостей.
     * 
     * @return string Выводит все новости из базы данных,
     * в формате JSON.
     * 
     * Пример:
     * [
     *  {
     *      "id":1,
     *      "title":"Первая новость",
     *      "body":"Длиииный текст",
     *      "date_create":"2024-01-21"
     *  },
     *  {
     *      "id":2,
     *      "title":"Вторая новость",
     *      "body":"Uncaught PDOException\u0435\u043d\u0442\u044b\/dev\",
     *      "date_create":"2024-01-21"
     *  },
     *  {
     *      "id":3,
     *      "title":"Оперная певица из Уфы в четвертый раз помогла полиции поймать мошенников",
     *      "body":"Неизвестные снова связались с артисткой театра по городскому номеру и сообщили, что ее племянница спровоцировала ДТП.",
     *      "date_create":"2024-01-22"
     *  },
     *  {
     *      "id":4,
     *      "title":"Новость 6",
     *      "body":"Уже 4 новость!",
     *      "date_create":"2024-01-22"
     *  }
     * ]
     */
    public function index(): string
    {
        $news = (new NewsRepository())->getNews();

        return json_encode($news);
    }

    /**
     * Добавление новости.
     * 
     * @param string $title Заголовок новой новости.
     * @param string $body  Тело новости.
     * 
     * @return string Выводит информацию, после добавления новости.
     */
    public function addNews(string $title, string $body): string
    {
        $news = new News();
        $news->setTitle($title);
        $news->setBody($body);

        (new NewsRepository())->addNews($news);

        http_response_code(201);
        return json_encode(['status' => 'ok', 'message' => 'Новасть была добавлена.']);
    }

    /**
     * Обновление новости.
     * 
     * Обновление может просиходить как одного поля, так и основных,
     * сделано для разграничения возможностей.
     * 
     * @param int id     Номер новости.
     * @param int $title Заголовок новсти.
     * @param int $body  Тело новсти.
     * 
     * @return string Выводит информацию об обновление записи.
     */
    public function updateNews(int $id, string $title = null, string $body = null): string
    {
        $updateNews = new News();
        $updateNews->setId($id);

        if ($title)
        {
            $updateNews->setTitle($title);
        }

        if ($body)
        {
            $updateNews->setBody($body);
        }

        (new NewsRepository())->updateNews($updateNews);

        return json_encode(['status' => 'ok', 'message' => 'Новость была обновлена']);
    }

    /**
     * Выводит конкретную новость.
     * 
     * @param int $id Номер новости.
     * 
     * @return string Одна новость.
     * 
     * Пример:
     * [
     *  {
     *      "id":2,
     *      "title":"Вторая новость",
     *      "body":"Uncaught PDOException\u0435\u043d\u0442\u044b\/dev\",
     *      "date_create":"2024-01-21"
     *  },
     * ]
     */
    public function getById(int $id): string
    {
        $news = (new NewsRepository())->getNewsById($id);

        return json_encode($news);
    }

    /**
     * Удаление новости.
     * 
     * @param int $id Номер новости.
     * 
     * @return string Выводит информацию об удаление новости.
     */
    public function removeById(int $id): string
    {
        $news = (new NewsRepository())->removeNews($id);

        if(empty($news))
        {
            json_encode(['status' => 'ok', 'message' => 'Новость была удалена.']);
        }

        return json_encode(['status' => 'ok', 'message' => 'Новость была удалена.']);
    }
}
