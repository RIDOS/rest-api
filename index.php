<?php

require_once './vendor/autoload.php';

use App\Controller\NewsController;
use App\Router;

// Маршруты.
Router::get('/api/news', [NewsController::class, 'index']);
Router::get('/api/news/:id', [NewsController::class, 'getOne']);
