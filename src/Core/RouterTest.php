<?php
namespace App\Core;

use Psr\Http\Message\ServerRequestInterface;
//use App\Core\RouteTest;

/**
 * Class RouterTest
 * @package App\Core
 */
class RouterTest
{
    private $router;

    public function __construct()
    {

    }

    /**
     * @param string $path
     * @param callable $callable
     * @param string $name
     */
    public function get(string $path, callable $callable, string $name)
    {

    }

    /**
     * @param ServerRequestInterface $request
     * @return RouteTest|null
     */
    public function match(ServerRequestInterface $request): ?RouteTest
    {

    }

}