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
        $this->form = new Form(array());
        $this->form_valid = new Form_validation();
    }

    /**
     *
     */
    public function read_all_posts()
    {
        $posts = $this->manager->get_all_posts();

        $count = $this->manager->testCount();
//        $countUri = $this->manager->total_uri();

        $title = "Tous les posts";
        $subTitle = 'Retrouvez tous les posts du blog';

        $this->render('front/posts.html.twig', ['posts' => $posts, 'title' => $title, 'sub' => $subTitle, 'count' => $count]);
    }

    /**
     * @param $id
     */
    public function get_single($id)
    {
        $post = $this->manager->get_single_post($id);
        $count = $this->manager->testCount();
        $subTitle = 'Retrouvez tous les posts du blog';

        $this->render('back/single_element.html.twig', ['post' => $post, 'sub' => $subTitle, 'count' => $count]);
    }

    /**
     *
     */
    public function create_post_view()
    {
        $title = 'Ajouter un billet';
        $subTitle = 'Ce formulaire vous permet d\'ajouter un nouveau billet';
        $input = $this->form->inputs([
            'label' => 'Mon titre',
            'name' => 'title',
            'placeholder' => 'Mon titre de billet',
            'type' => 'text',
            'class' => 'input-title',
//            'length' => 2,
        ]);
        $author = $this->form->inputs([
            'label' => 'votre nom',
            'name' => 'pseudo',
            'placeholder' => 'auteur du post',
            'type' => 'text'
        ]);
        $textarea = $this->form->inputs([
            'field' => 'textarea',
            'name' => 'content',
            'label' => 'Contenu du post',
            'rows' => 15
        ]);
        $integer = $this->form->inputs([
            'name' => 'integer',
            'label' => 'integer',
            'placeholder' => 'integer',
            'type' => 'int'
        ]);
        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'placeholder' => 'Créer',
        ]);

//        $count = $this->manager->count();

        $this->render('back/add_form.html.twig', ['title' => $title, 'sub' => $subTitle, 'count' => $this->count, 'input' => $input, 'textarea' => $textarea, 'author' => $author, 'integer' => $integer, 'submit' => $submit]);
    }

    public function create_signle_post($title, $content)
    {
        //$this->form_valid->validate();
        $Post = new Post([]);

        $Post->setTitle($title);
        $Post->setContent($content);

        $this->manager->create_post($Post);
    }

}
