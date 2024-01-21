<?php

namespace App;

use App\Controller\NewsController;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

/**
 * Маршрутизатор.
 * 
 * Данный класс позваляет создавать статические методы,
 * для реализации маршрутов.
 * 
 * Например:
 *  Router::get('/api/news', [NewsController::class, 'index']);
 *  Router::post('/api/news', [NewsController::class, 'index']);
 *
 *  Router::get('/api/news/:id', [NewsController::class, 'getOne']);
 *  Router::patch('/api/news/:id', [NewsController::class, 'getOne']);
 *  Router::put('/api/news/:id', [NewsController::class, 'getOne']);
 *  Router::delete('/api/news/:id', [NewsController::class, 'getOne']);
 * 
 * @author a.imaev <smartsites.dev27@gmail.com>
 */
class Router
{
    public static function get(string $url, array $method): void
    {
        if (Router::isUrl($url))
        {
            if (!isset($method[0]))
            {
                throw new \Exception('Отсутсвует экземпляр класса.');
            }

            if (!isset($method[1]))
            {
                throw new \Exception('Отсутсвует метод класса.');
            }

            $controller = new $method[0]();
            $action = $method[1];

            echo $controller->$action();
        }
    }

    /**
     * Проверка на сущестование маршрута.
     * 
     * @param string $url Маршрут пользователя.
     * 
     * @return bool При ошибке, выводит Error,
     * иначе True.
     */
    private static function isUrl(string $url): bool
    {
        if ($url !== $_SERVER['REQUEST_URI']) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Не верный контроллер.'
            ]);
            return false;
        }

        return true;
    }

    /**
     * Удаляет строку с URL.
     * 
     * @param string $url Маршрут.
     * 
     * @return string|null В случае успеха выводит строку без парамтра,
     * иначе null.
     * 
     * Пример:
     *  Input:  '/api/news/:id'
     *  Output: '/api/news/'
     *
     *  Input:  '/api/news/:id/'
     *  Output: '/api/news/'
     *  Output: '/api/news/'
     *
     *  Input:  '/api/news/2/'
     *  Output: '/api/news/'
     */
    private static function replaceUrl(string $url): string|null
    {
        $array = explode('/', $url);

        foreach($array as $key => $value)
        {
            if (str_contains($value, ':') || is_numeric($value))
            {
                $temp = str_replace($value, '', $url);
                return str_replace('//', '/', $temp);
            }
        }

        return null;
    }
}
