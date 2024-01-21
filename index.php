<?php

require_once './vendor/autoload.php';

use App\Controller\NewsController;


// echo (new NewsController())->index();
echo (new NewsController())->getOne(2);
