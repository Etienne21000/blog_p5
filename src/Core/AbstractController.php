<?php
namespace App\Core;

use \Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use \Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    private $twig;

   /* public function __construct()
    {
        $twig = $this->twig;
    }*/

    public function render($view, $params = [])
    {
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/src/View/Template');

        $this->twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);

        $this->twig->addGlobal('server', $_SERVER);
        $this->twig->addGlobal('post', $_POST);
        $this->twig->addGlobal('get', $_GET);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);

        try{
            echo $this->twig->render($view, $params);
        }
        catch (LoaderError $e) {
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }

    }

}
