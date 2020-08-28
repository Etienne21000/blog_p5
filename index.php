<?php
session_start();

require_once (__DIR__ .'/vendor/autoload.php');

use App\Core\Router;
use App\Controller\MasterController;
use App\Controller\PostController;

$router = new Router($_GET['url']);

$router->get('/home', function(){

    $controller = new MasterController();

    $controller->index();

});

$router->get('/', function(){

    $controller = new MasterController();

    $controller->index();

});

$router->get('/msg', function(){

    $controller = new MasterController();

    $controller->get_msg();

});

$router->get('/posts', function(){

    $postController = new PostController();

    $postController->read_all_posts();

});

$router->get('/singlePost/{id}' , function($param){

    $postController = new PostController();

    (int)$id = $param[0];

    $postController->get_single($id);

});


$router->run();
