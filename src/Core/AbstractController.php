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
    /**
     * Renderer method based on twig templating system
     * @var $twig
     */
    private $twig;

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

    /**
     * Method for dispatching view on user role
     */
    public function acces_denied(){
        $error_msg = "Il semblerait que vous n'ayez pas accès à cette section";
        $error_title= "Accès refusé";
        $error_subtitle = "L'accès à cette page est réservé aux administrarteurs du site";

        $this->render('front/forbidden_access.html.twig', ['error_msg' => $error_msg, 'error_title' => $error_title, 'error_subtitle' => $error_subtitle]);
    }

    public function error_view(){
        $error_msg = "Oups ! il semblerait que cette page n'existe pas, vous pouvez retourner sur la page d'accueil du site";
        $error_title= "Page introuvable";
        $error_subtitle = "La page que vous essayez d'afficher n'éxiste pas";

        $this->render('front/error_page.html.twig', ['error_msg' => $error_msg, 'error_title' => $error_title, 'error_subtitle' => $error_subtitle]);
    }
}
