<?php
session_start();

require_once (__DIR__ .'/vendor/autoload.php');

use App\Core\Router;
use App\Core\App;
use App\Controller\MasterController;
use \App\Controller\PostController;
use App\Controller\UserController;
use App\Controller\CommentController;
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

    $view = "front";
    $where = 1;

    $postController = new PostController();

    $postController->read_all_posts($view, $where);

});

$router->get('list-posts', function(){

    $view = "back";
    $where = 1;

    $postController = new PostController();

    $postController->read_all_posts($view, $where);
});

$router->get('list-draft', function(){

    $view = "back";
    $where = 0;

    $postController = new PostController();

    $postController->read_all_posts($view, $where);
});

$router->get('/singlePost/{id}', function ($param) {

    (int)$id = $param[0];

    $postController = new PostController();

    $view = "front";

    $postController->get_single($id, $view);

});

$router->get('singlePostBack/{id}', function($param){

    $postController = new PostController();

    (int)$id = $param[0];
    $view = "back";

    $postController->get_single($id, $view);
});

$router->get('/addPostForm', function () {

    $postController = new PostController();

    $postController->create_post_view();

});

$router->post('/addPost', function () {

    $postController = new PostController();

    $postController->create_post();

});

$router->get('/updatePostForm/{id}', function($param){

    (int)$post_id = $param[0];

    $postController = new PostController();

    $postController->update_post_view($post_id);
});

$router->post('/updatePost/{id}', function($param){

    (int)$post_id = $param[0];

    $postController = new PostController();

    $postController->update_post($post_id);
});

$router->post('/addComment/{id}', function($param){

    (int)$post_id = $param[0];

    $comController = new CommentController();

    $comController->add_comment($post_id);

});

$router->get('/downloadCV', function () {

    $controller = new MasterController();

    $controller->download_cv();
});

$router->get('/disconnect_user', function() {

    $controller = new UserController();

    $controller->disconnect_user();
});

$router->run();
