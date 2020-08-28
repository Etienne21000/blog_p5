<?php
namespace App\Core;

class Router
{
    private $url;
    private $routes = [];
    private $routesNames = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');

    }

    private function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        if(is_string($callable) && $name === null)
        {
            $name = $callable;
        }

        if($name)
        {
            $this->routesNames[$name] = $route;
        }

        return $route;
    }

    public function url($name, $params = [])
    {
        if(!isset($this->routesNames[$name]))
        {
            throw new \Exception('Aucune route ne correspond');
        }

        $this->routesNames[$name]->getUrl($params);
    }

    public function run()
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
        {
            throw new \Exception('Aucune url trouvée');
        }

        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
        {
            if($route->match($this->url))
            {
                return $route->call();
            }
        }
    }
    
}