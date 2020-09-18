<?php
namespace App\Core;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use function Http\Response\send;

class App
{
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if(!empty($uri) && $uri[-1] === '/')
        {
            return (new Response())
            ->withStatus(301)
            ->withHeader('Location', substr($uri,0, -1));
        }

            if($uri === '/index')
        {
            return new Response(200, [], '<h1>Bienvenu sur mon blog</h1>');
        }

        return new Response(404, [], '<h1>Erreur 404</h1>');

    }
}