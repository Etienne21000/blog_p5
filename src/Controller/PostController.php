<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;
use App\Model\Form;
use App\Model\Form_validation;
use App\Model\Post;

class PostController extends AbstractController
{
    private $manager;
    private $form;
    private $form_valid;
    private $post;
    private $count;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->manager = new PostManager();
        $this->form = new Form(array(
//            'title' => 'Mon nouveau billet',
//            'name' => 'title'
        ));
        $this->form_valid = new Form_validation();
    }

    public function read_all_posts()
    {
        $posts = $this->manager->get_all_posts();

        $count = $this->manager->testCount();
//        $countUri = $this->manager->total_uri();

        $title = "Tous les posts";
        $subTitle = 'Retrouvez tous les posts du blog';
//        $count = $this->manager->count();

//        $form_params = array(
//            'label' => 'Bonjour',
//            'for' => 'bonjour',
//            'name' => 'bonjour',
//            'placeholder' => 'dite bonjour',
//            'class' => 'classbjr',
//            'id' => 'bjr'
//        );
//        $param = $form_params[0]['bonjour'];

//        $form1 = $this->form->set_params($param);
//
//        var_dump($form1);
//        exit();

        $this->render('back/all_posts_view.html.twig', ['posts' => $posts, 'title' => $title, 'sub' => $subTitle, 'count' => $count]);
    }

    public function get_single($id)
    {

        $post = $this->manager->get_single_post($id);

        $count = $this->manager->testCount();

//        $title = 'Titre du post';
        $subTitle = 'Retrouvez tous les posts du blog';


        $this->render('back/single_element.html.twig', ['post' => $post, 'sub' => $subTitle, 'count' => $count]);
    }

    public function get_form_view()
    {
        $title = 'Ajouter un billet';
        $subTitle = 'Ce formulaire vous permet d\'ajouter un nouveau billet';
        $input = $this->form->inputs([
            'label' => 'Mon titre',
            'name' => 'title',
            'placeholder' => 'Mon titre de billet',
            'type' => 'text',
            'class' => 'input-title',
        ]);
        $textarea = $this->form->textArea([
            'name' => 'content',
            'label' => 'Contenu du post',
            'placeholder' => 'Commencez à rédiger votre billet...',
        ]);
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
