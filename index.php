<?php
session_start();

require_once (__DIR__ .'/vendor/autoload.php');

use App\Core\Router;
use App\Core\App;
//use GuzzleHttp\Psr7\ServerRequest;
//use function Http\Response\send;
use App\Controller\MasterController;
use \App\Controller\PostController;
//use FastRoute\Route;

//function segmentUri()
//{
//    $segments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
//
//    return $segments;
//}

//use FastRoute;
/*$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $controller = new MasterController();
    $post = new PostController();
    $uri = $_SERVER['REQUEST_URI'];

    $segments = rawurldecode(parse_url($uri, PHP_URL_PATH));
    $id = (int)$segments[2];

//    $segments = segmentUri();
//    if($_SERVER['REQUEST_METHOD'] === 'GET')
//    {
    if($uri === '/')
    {
        $r->get( '/', $controller->index());
    }
    elseif ($uri === '/posts')
    {
        $r->get( '/posts', $post->read_all_posts());
    }
    elseif ($uri === '/msg')
    {
        $r->get('/msg', $controller->get_msg());
    }
    elseif ($uri === '/singlePost/'.$segments[2])
    {
        $r->get('/singlePost/{id:\d+}', $post->get_single($id));
    }
    elseif ($uri === '/singlePost/2')
    {
        $r->get('/singlePost/{id:\d+}', $post->get_single($id));
    }

//        switch ($_SERVER['REQUEST_METHOD'] === 'GET')
//        {
//            case $uri === '/';
//                $r->get( '/', $controller->index());
//                break;
//
//            case $uri === 'posts';
//                $r->get( '/posts', $post->read_all_posts());
//                break;
//        }
//    }
});*/

//$httpMethod = $_SERVER['REQUEST_METHOD'];
//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

//$httpMethod = $_SERVER['REQUEST_METHOD'];
//$dispatcher->dispatch($httpMethod, $uri);

//if($uri === '/posts')
//{
//    $dispatcher->dispatch('GET', '/posts');
//}
//elseif ($uri === '/')
//{
//    $dispatcher->dispatch('GET', '/');
//}



//$httpMethod = $_SERVER['REQUEST_METHOD'];
//$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
//if (false !== $pos = strpos($uri, '?')) {
//    $uri = substr($uri, 0, $pos);
//}
//$uri = rawurldecode($uri);


//$app = new App();
////$request = new ServerRequest('GET', '/index');
//$response = $app->run(ServerRequest::fromGlobals());
//
//send($response);

//$app->run($request);




$router = new Router($_GET['url']);

$_SESSION['user'] = 'Etienne';
$_SESSION['role'] = 'administrateur';


$router->get('/dashbord', function(){

    $controller = new MasterController();
//    $post = new PostController();
//
//    $post->count_all_posts();

    $controller->dashbord();

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

$router->get('/addPostForm', function(){

    $postController = new PostController();

    $postController->create_post();

});

$router->post('/addPost', function(){

    $postController = new PostController();

    $postController->create_signle_post();

});

$router->run();

//$request = new ServerRequest('GET', '/posts');
//
//$response = $router->run(ServerRequest::fromGlobals());
//
//$response = $router->run($request);
