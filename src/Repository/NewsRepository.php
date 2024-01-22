<?php

namespace App\Repository;

use App\DataBase;
use App\Entity\News;

/**
 * Репозитрой для работы с новостями.
 * 
 * Используется в контроллерах, для разграничения ответственности.
 *
 * На будущее: Весь CRUD нужно будет убрать в абстракцию, для того чтобы не писать,
 * для каждой новой сущности отдельные запросы.
 */
class NewsRepository
{
    use DataBase;

    /**
     * Получение новостей.
     * 
     * @return array Ассоциативный массив новостей.
     */
    public function getNews(): array
    {
        return self::query('SELECT * FROM News');
    }


    /**
     * Получение новости.
     * 
     * @param int $id Номер новости
     * 
     * @return array Ассоциативный массив - новости.
     */
    public function getNewsById(int $id): array
    {
        return self::query("
            SELECT * 
            FROM News 
            WHERE id = $id;
        ");
    }

    /**
     * Добавление записи.
     * 
     * @param News $news Сущность новости.
     * 
     * @return array Информация о добавлении записи.
     */
    public function addNews(News $news): array
    {
        $title = $news->getTitle();
        $body = $news->getBody();
        $dateCreate = (string) $news->getDateCreate();

        return self::query("
            INSERT INTO News (`title`, `body`, `date_create`)
            VALUES ('$title', '$body', '$dateCreate');
        ");
    }


    /**
     * Обновление записи.
     * 
     * @param News $news Сущность новости.
     * 
     * @return array Информация об изменении записи.
     */
    public function updateNews(News $news): array
    {
        $id = $news->getId();
        $title = $news->getTitle() ?? null;
        $body = $news->getBody() ?? null;

        $query = "UPDATE News SET ";

        if ($title)
        {
            $query .= " title = '$title' ";
        }

        if ($body)
        {
            if ($title) $query .= ", ";
            $query .= " body = '$body' ";
        }

        $query .= "WHERE id = '$id'";

        return self::query($query);
    }

    /**
     * Удаление записи.
     * 
     * @param int $id Номер записи.
     * 
     * @return array Информация об удалении записи.
     */
    public function removeNews(int $id): array
    {
        return self::query("
            DELETE FROM News WHERE id = '$id'
        ");
    }
}