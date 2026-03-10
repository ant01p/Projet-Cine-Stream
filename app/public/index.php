<?php
use Cine\App\Controller\FilmController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../.env.php';

$filmController = new FilmController;

if(isset($_GET['route'])) {
    $route = $_GET['route'];
} else {
    $route ='index';
}

if ($route === 'index') {
    $filmController->index();
}

