<?php
session_start();

require_once (__DIR__ .'/vendor/autoload.php');

use App\Core\Router;
use App\Core\App;
use App\Controller\MasterController;
use \App\Controller\PostController;
use App\Controller\UserController;

$router = new Router($_GET['url']);

$_SESSION['user'] = 'Etienne';
$_SESSION['role'] = 'administrateur';


$router->get('/dashbord', function(){

    $controller = new MasterController();

    $controller->dashbord();

});

$router->get('/create_user', function() {

    $controller = new UserController();

    $controller->create_user();
});

$router->get('/connect_user', function(){
    $controller = new UserController();
    $controller->connect_user();
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

    $file = 'front/posts.html.twig';

    $postController = new PostController();

    $postController->read_all_posts($file);

});

$router->get('/singlePost/{id}' , function($param){

    $postController = new PostController();

    (int)$id = $param[0];

    $postController->get_single($id);

});

$router->get('/addPostForm', function(){

    $postController = new PostController();

    $postController->create_post();

});

$router->post('/addPost', function(){

    $postController = new PostController();

    $postController->create_signle_post();

});

$router->get('/downloadCV', function(){
    $controller = new MasterController();
    $controller->download_cv();
});

$router->run();

//$request = new ServerRequest('GET', '/posts');
//
//$response = $router->run(ServerRequest::fromGlobals());
//
//$response = $router->run($request);
