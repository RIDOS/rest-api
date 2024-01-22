<?php

namespace App;

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
 *  Router::get('/api/news', func() { echo (new ... )->index(); });
 *  Router::post('/api/news', func(...) { echo (new ... )->post(...); });
 *
 *  Router::get('/api/news/:id',  func(int $id) { echo (new ... )->getOne($id); });
 *  Router::patch('/api/news/:id', func(...) { echo (new ... )->post(...); });
 *  Router::put('/api/news/:id', func(...) { echo (new ... )->post(...); });
 *  Router::delete('/api/news/:id', func(...) { echo (new ... )->post(...); });
 * 
 * @author a.imaev <smartsites.dev27@gmail.com>
 */
class Router
{
    private static $routes = [];

    public static function addRoute($method, $url, $action)
    {
        self::$routes[] = ['method' => $method, 'url' => $url, 'action' => $action];
    }

    public static function get($url, $action)
    {
        self::addRoute('GET', $url, $action);
    }

    public static function post($url, $action)
    {
        self::addRoute('POST', $url, $action);
    }

    public static function patch($url, $action)
    {
        self::addRoute('PATCH', $url, $action);
    }

    public static function put($url, $action)
    {
        self::addRoute('PUT', $url, $action);
    }

    public static function delete($url, $action)
    {
        self::addRoute('DELETE', $url, $action);
    }

    /**
     * Обработка входящего запроса и сравнение с указаными маршрутами.
     */
    public static function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes as $route) {
            $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";
            $matches = [];

            if ($requestMethod == $route['method'] && preg_match($pattern, $requestUrl, $matches)) {
                array_shift($matches);
                call_user_func_array($route['action'], $matches);
                return;
            }
        }

        // Обработка ситуации, когда маршрут не найден.
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['status' => 'error', 'message' => 'Маршрут не найден']);
    }
}
