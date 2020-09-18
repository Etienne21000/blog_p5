<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;
use App\Model\Form;
use App\Model\Post;

class PostController extends AbstractController
{
    private $manager;
    private $form;
    private $post;
    private $count;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->manager = new PostManager();
        $this->form = new Form(array(
            'title' => 'Mon nouveau billet'
        ));
    }

    public function read_all_posts()
    {
        $posts = $this->manager->get_all_posts();

        $count = $this->manager->countPosts();

        $title = "Tous les posts";
        $subTitle = 'Retrouvez tous les posts du blog';
//        $count = $this->manager->count();

        $this->render('back/all_posts_view.html.twig', ['posts' => $posts, 'title' => $title, 'sub' => $subTitle, 'count' => $count]);
    }

    public function get_single($id)
    {

        $post = $this->manager->get_single_post($id);

//        $title = 'Titre du post';
        $subTitle = 'Retrouvez tous les posts du blog';
//        $count = $this->manager->count();


        $this->render('back/single_element.html.twig', ['post' => $post, 'sub' => $subTitle, 'count' => $this->count]);
    }

    public function get_form_view()
    {
        $title = 'Ajouter un billet';
        $subTitle = 'Ce formulaire vous permet d\'ajouter un nouveau billet';
        $input = $this->form->inputs('title');
        $textarea = $this->form->textArea();
        $submit = $this->form->submit();

//        $count = $this->manager->count();


        $this->render('back/add_form.html.twig', ['title' => $title, 'sub' => $subTitle, 'count' => $this->count, 'input' => $input, 'textarea' => $textarea, 'submit' => $submit]);
    }

    /*public function create_signle_post($title, $content)
    {
        $post = new Post([$data]);

        if(!empty($_POST['title']) && !empty($_POST['content']))
        {
            $post->setTitle($title);
            $post->setContent($content);


            $this->manager->create_post($post);
            header('Location: /posts');

        }
        else{
            echo 'Impossible de créer le post';
        }

        echo '<pre>';
        echo print_r($post);
        echo '</pre>';
        exit();
    }*/

    public function create_signle_post()
    {
//        $post = new Post([$data]);

        if(!empty($_POST['title']) && !empty($_POST['content']))
        {
//            $post->create_post();

            $this->manager->create_post();
            header('Location: /posts');

        }
        else{
            echo 'Impossible de créer le post';
        }

        /*echo '<pre>';
        echo print_r($post);
        echo '</pre>';
        exit();*/
    }


   /* public function create_signle_post($title, $content)
    {
        $post = new Post([$data]);

        if(!empty($_POST['title']) && !empty($_POST['content']))
        {
            $this->post->setTitle($title);
            $this->post->setContent($content);


            $this->manager->create_post($this->post);
            header('Location: /posts');
        }
        else{
            echo 'Impossible de créer le post';
        }
    }*/
}
