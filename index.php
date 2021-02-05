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

//$_SESSION['id'] = 3;
//$_SESSION['role'] = 0;


//if(isset($_SESSION) && $_SESSION['role'] === 1){
    //$role->dispatche();

    $router->get('/dashboard', function(){

        $role = new User_role();
        $controller = new MasterController();

        $role->dispatch();

//        if ($role === TRUE){

            $controller->dashbord();
        /*}
        elseif ($role === FALSE){
            echo "interdit";

            $controller->index();

//            exit();
        }
        elseif (!$role)
        {
            echo "Vous devez vous connecter pour accéder à cette page";
            exit();
        }*/



    });
//}
//elseif(!isset($_SESSION) || $_SESSION['role'] === 0) {
//    $role->dispatche();

//if(!isset($role) || $role = 0) {
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

    $router->run();
//}

//$request = new ServerRequest('GET', '/posts');
//
//$response = $router->run(ServerRequest::fromGlobals());
//
//$response = $router->run($request);
