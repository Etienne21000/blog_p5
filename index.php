<?php
session_start();

require_once (__DIR__ .'/vendor/autoload.php');

use App\Core\Router;
use App\Core\App;
use App\Controller\MasterController;
use \App\Controller\PostController;
use App\Controller\UserController;
use App\Core\User_role;


$router = new Router($_GET['url']);

$router->get('/dashboard', function(){

    $controller = new MasterController();

    $controller->dashbord();
});

$router->get('/create_user', function () {

    $controller = new UserController();

    $controller->create_user_view();
});

$router->post('/add_user', function() {

    $controller = new UserController();

    $controller->create_user();
});

$router->get('/connect_user_view', function () {

    $controller = new UserController();

    $controller->connect_user_view();
});

$router->post('/connect_user', function() {

    $controller = new UserController();

    $controller->connect_user();

});

$router->get('/', function () {

    $controller = new MasterController();

    $controller->index();
});

$router->get('/posts', function () {

    $postController = new PostController();

    $postController->read_all_posts();

});

$router->get('/singlePost/{id}', function ($param) {

    $postController = new PostController();

    (int)$id = $param[0];

    $postController->get_single($id);

});

$router->get('/addPostForm', function () {

    $postController = new PostController();

    $postController->create_post_view();

});

$router->post('/addPost', function () {

    $postController = new PostController();

    $postController->create_signle_post();

});

$router->get('/downloadCV', function () {

    $controller = new MasterController();

    $controller->download_cv();
});

$router->get('/disconnect_user', function() {

    $controller = new UserController();

    $controller->disconnect_user();
});

/*if (http_response_code() != '200') {
    $router->get()
    $controller = new MasterController();

    $controller->error();
}*/

$router->run();
