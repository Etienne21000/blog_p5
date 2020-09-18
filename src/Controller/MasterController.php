<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;
use App\Model\ImageManager;
use App\Model\CommentManager;
use App\Model\UserManager;



class MasterController extends AbstractController
{
    private $PostManager;
    private $ImageManager;
    private $UserManager;
    private $CommentManager;

    public function __construct()
    {

        $this->PostManager = new PostManager();
        $this->ImageManager = new ImageManager();
        $this->UserManager = new UserManager();
        $this->CommentManager = new CommentManager();
    }

    Public function index()
    {
        $msg = 'Hello';

        $title = "Site web d'Etienne Juffard";
        $subTitle = 'Bienvenu sur mon blog';
        $countPosts = $this->PostManager->countPosts();

        /*$data = array(
            'name' => $title,
            'sub' => $subTitle
        );*/

        $this->render('back/index.html.twig', ['msg' => $msg, 'title' => $title, 'sub' => $subTitle, 'count' => $countPosts]);

    }

    public function get_msg()
    {
        $msg = 'Hello';
        $title = "Site web d'Etienne Juffard";
        $subTitle = 'Bienvenu sur mon blog';
        $countPosts = $this->PostManager->countPosts();

        $data = array(
            'msg' => $msg,
            'name' => $title,
                 'sub' => $subTitle
        );

        $this->render('back/msg.html.twig', ['msg' => $msg, 'title' => $title, 'sub' => $subTitle, 'count' => $countPosts]);

    }

    /*public function count_all_posts()
    {
        $countPosts = $this->PostManager->count();

        return $countPosts;
    }*/

}
