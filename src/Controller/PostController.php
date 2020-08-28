<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;

class PostController extends AbstractController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new PostManager();
    }

    public function read_all_posts()
    {
        $posts = $this->manager->get_all_posts();

        $title = "Tous les posts";
        $subTitle = 'Retrouvez tous les posts du blog';

        $this->render('back/all_posts_view.html.twig', ['posts' => $posts, 'title' => $title, 'sub' => $subTitle]);
    }

    public function get_single($id)
    {

        $post = $this->manager->get_single_post($id);

//        $title = 'Titre du post';
        $subTitle = 'Retrouvez tous les posts du blog';

        $this->render('back/single_element.html.twig', ['post' => $post, 'sub' => $subTitle]);

    }

}
