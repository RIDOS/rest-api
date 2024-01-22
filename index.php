<?php

require_once './vendor/autoload.php';

use App\Controller\NewsController;
use App\Router;

// Вывод всех новостей.
Router::get('/api/news', function() {
    echo (new NewsController())->index();
});

// Добавление новой новости.
Router::post('/api/news', function() {
    if (!isset($_POST['title']))
    {
        echo json_encode(['status' => 'error', 'message' => 'Отсуствует обязательный параметр: title.']);
    }

    if (!isset($_POST['body']))
    {
        echo json_encode(['status' => 'error', 'message' => 'Отсуствует обязательный параметр: body.']);
    }

    echo (new NewsController())->addNews(
        title: (string)trim($_POST['title']),
        body:  (string)trim($_POST['body'])
    );
});

// Вывод конкретной новости.
Router::get('/api/news/:id', function(int $id) {
    echo (new NewsController())->getById(id: $id);
});

// Обновление новости [PATCH].
Router::patch('/api/news/:id', function(int $id) {
    $data = json_decode(file_get_contents('php://input'));
    
    $title = $data->title ?? null;
    $body = $data->body ?? null;

    if ($title === null && $body === null)
    {
        echo json_encode(
            [
                'status' => 'error',
                'message' => 'Необходимо предоставить хотя бы один из парметров: title, body.'
            ]
        );
    }

    echo (new NewsController())->updateNews($id, $title, $body);
});

// Обновление новости [PUT].
Router::put('/api/news/:id', function(int $id) {
    $data = json_decode(file_get_contents('php://input'));
    
    if (!isset($data->title))
    {
        echo json_encode(['status' => 'error', 'message' => 'Отсуствует обязательный параметр: title.']);
    }

    if (!$data->body)
    {
        echo json_encode(['status' => 'error', 'message' => 'Отсуствует обязательный параметр: body.']);
    }

    echo (new NewsController())->updateNews($id, $data->title, $data->body);
});

// Удаление новости.
Router::delete('/api/news/:id', function(int $id) {
    if (!isset($id))
    {
        echo json_encode(['status' => 'error', 'message' => 'Отсуствует обязательный параметр: id.']);
    }

    echo (new NewsController())->removeById(id: $id);
});

Router::dispatch();

