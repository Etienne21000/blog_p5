<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;
use App\Model\CommentManager;
use App\Model\Form;
use App\Model\Form_validation;
use App\Model\Post;
use App\Core\User_role;

class PostController extends AbstractController
{
    private $manager;
    private $CommentManager;
    private $form;
    private $form_valid;
    private $post;
    private $count;
    private $user_role;
    private $post_values = [];

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->manager = new PostManager();
        $this->CommentManager = new CommentManager();
        $this->form = new Form(array());
        $this->form_valid = new Form_validation();
        $this->user_role = new User_role();
        $this->post = new Post([]);
    }

    /**
     * Method to get all posts
     * @param $view
     * param used to dispatch views
     * @param $where
     */
    public function read_all_posts($view, $where)
    {
        $posts = $this->manager->get_all_posts($where);

        $count = $this->manager->testCount();

        $title = "Tous les posts";
        $subTitle = 'Retrouvez tous les posts du blog';

        if($view == "front"){
            $this->render('front/posts.html.twig', ['posts' => $posts, 'title' => $title, 'sub' => $subTitle, 'count' => $count]);
        }
        elseif($view == "back"){
            $this->render('back/all_posts_view.html.twig', ['posts' => $posts, 'title' => $title, 'sub' => $subTitle, 'count' => $count]);
        }
    }

    /**
     * Method to get single post by id
     * @param $id
     * @param $view
     */
    public function get_single($id, $view)
    {
        $comments = $this->CommentManager->get_comments_by_post($id);
        $post = $this->manager->get_single_post($id);

        $title = $this->form->inputs([
            'label' => 'Titre',
            'name' => 'title',
            'placeholder' => 'Mon titre',
            'type' => 'text',
            'class' => 'input-title'
        ]);

        $content = $this->form->inputs([
            'label' => 'commentaire',
            'name' => 'content',
            'type' => 'text',
            'field' => 'textarea',
            'class' => 'input-content',
            'rows' => 5
        ]);

        $author = $this->form->inputs([
            'label' => 'Commenté par '.$_SESSION['pseudo'],
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => $_SESSION['user_id'],
        ]);

        $post_id = $this->form->inputs([
            'name' => 'post_id',
            'type' => 'hidden',
            'value' => $post->post_id(),
        ]);

        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn-primary',
            'placeholder' => 'Commenter',
        ]);

        if($view == "front"){
            $this->render('front/blog-single-post.html.twig', ['post' => $post, 'comments' => $comments, 'post_id' => $post_id, 'title' => $title, 'content' => $content, 'submit' => $submit, 'author' => $author]);
        }
        elseif($view == "back"){
            $this->render('back/single_post.html.twig', ['post' => $post]);

        }
    }

    /**
     * Method to call the form to create a post
     */
    public function create_post_view()
    {
        $role = $this->user_role->dispatch();
        $param = "create";

        $title = 'Ajouter un article';
        $subTitle = 'Ce formulaire vous permet d\'ajouter un nouvel article';

        $input = $this->form->inputs([
            'label' => 'Mon titre',
            'name' => 'title',
            'placeholder' => 'Mon titre d\'article',
            'type' => 'text',
            'class' => 'input-title',
        ]);
        $author = $this->form->inputs([
            'label' => 'Cet article sera publié par '.$_SESSION['pseudo'],
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => $_SESSION['user_id'],
        ]);
        $textarea = $this->form->inputs([
            'field' => 'textarea',
            'name' => 'content',
            'label' => 'Contenu',
            'rows' => 15
        ]);

        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn-primary',
            'placeholder' => 'Créer',
        ]);

//        $count = $this->manager->count();
        if($role === 1) {
            $this->render('back/add_form.html.twig', ['title' => $title, 'sub' => $subTitle, 'count' => $this->count, 'input' => $input, 'textarea' => $textarea, 'author' => $author, 'submit' => $submit, 'param' => $param]);
        }
        elseif ($role === 0 || $role === 2)
        {
            $this->acces_denied();
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function update_post_view($id){

        $post = $this->manager->get_single_post($id);

        $role = $this->user_role->dispatch();
        $param = "update";

        $title = 'Mettre à jour l\'article';
        $subTitle = 'Ce formulaire vous permet de modifier votre article';
        $pseudo = $post->pseudo();
        $post_id = $post->post_id();

        $input = $this->form->inputs([
            'label' => 'Mon titre',
            'name' => 'title',
            //'placeholder' => $this->post_values['title'],
            'type' => 'text',
            'class' => 'input-title',
            'value' => $post->title(),
        ]);

        $id_post = $this->form->inputs([
            'name' => 'post_id',
            'type' => 'hidden',
            'value' => $post->post_id(),
        ]);

        $textarea = $this->form->inputs([
            'field' => 'textarea',
            'name' => 'content',
            'label' => 'Contenu',
            'rows' => 15,
            'value' => $post->content()

        ]);
        $status = $this->form->inputs([
            'name' => 'status',
            'field' => 'select',
            'type' => 'select',
            'label' => 'status',
            'text' => 'Brouillon',
            'value' => $post->status(),
        ]);
        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn-success',
            'placeholder' => 'Mettre à jour',
        ]);

        if($role === 1) {
            $this->render('back/add_form.html.twig', ['id' => $post_id, 'pseudo' => $pseudo, 'title' => $title, 'sub' => $subTitle, 'count' => $this->count, 'input' => $input, 'textarea' => $textarea, 'status' => $status, 'submit' => $submit, 'param' => $param, 'post_id' => $id_post]);
        }
        elseif ($role === 0 || $role === 2)
        {
            $this->acces_denied();
        }
//        }
    }

    /**
     * @param $title
     * @param $content
     * @param $user_id
     */
    private function add_post($title, $content, $user_id)
    {
        $this->post->setTitle($title);
        $this->post->setContent($content);
//        $this->post->setStatus($status);
        $this->post->setUserid($user_id);

        $this->manager->create_post($this->post);
    }

    public function create_post(){

        if(!empty($_POST)){

            $validate = true;

            if (empty($_POST['title']) || strlen($_POST['title']) > 80) {
                $validate = false;
                $error = 1;
            }

            if (empty($_POST['user_id'])) {
                $validate = false;
                $error = 2;
            }

            if (empty($_POST['content'])) {
                $validate = false;
                $error = 3;
            }

//            if (empty($_POST['status'])) {
//                $validate = false;
//                $error = 4;
//            }

            if($validate){

                $this->add_post($_POST['title'], $_POST['content'], $_POST['user_id']);

                header('Location: /dashboard');
            }
            else{
                $error = 5;
            }
        }

    }

    private function post_update($title, $content, $post_id){
        $this->post->setTitle($title);
        $this->post->setContent($content);
        $this->post->setPostid($post_id);
//        $this->post->setUserid($user_id);

        $this->manager->update_post($this->post);
    }

    public function update_post($post_id){

        $post_id = $this->manager->get_single_post($post_id);

        if(!empty($_POST)){

            $validate = true;

            if (empty($_POST['title']) || strlen($_POST['title']) > 80) {
                $validate = false;
                $error = 1;
            }

            /*if (empty($_GET['post_id'])) {
                $validate = false;
                $error = 2;
            }*/

            if (empty($_POST['content'])) {
                $validate = false;
                $error = 3;
            }

//            if (empty($_POST['status'])) {
//                $validate = false;
//                $error = 4;
//            }

            if($validate){

                $this->post_update($_POST['title'], $_POST['content'], $_POST['post_id']);

                header('Location: /list-posts');
            }
            else{
                $error = 5;
            }
        }
    }

}
