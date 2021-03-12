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

    /**
     * PostController constructor.
     */
    public function __construct(){
        $this->manager = new PostManager();
        $this->CommentManager = new CommentManager();
        $this->form = new Form(array());
        $this->form_valid = new Form_validation();
        $this->user_role = new User_role();
        $this->post = new Post([]);
    }

    private function count_posts(){
        $count = [
            'published' => $this->manager->count_posts('status = 1'),
            'drafted' => $this->manager->count_posts('status = 0'),
        ];
        return $count;
    }

    /**
     * Method to get all posts
     * @param $view
     * param used to dispatch views
     * @param $where
     */
    public function read_all_posts($view, $where)
    {
        $count_post = $this->count_posts();
        $posts = $this->manager->get_all_posts($where);
        $title = "Tous les posts";
        $subTitle = 'Retrouvez tous les posts du blog';
        if($view == "front"){
            $this->render('front/posts.html.twig', ['posts' => $posts, 'title' => $title, 'sub' => $subTitle]);
        }
        elseif($view == "back"){
            $this->render('back/all_posts_view.html.twig', ['count' => $count_post,'posts' => $posts, 'title' => $title, 'sub' => $subTitle]);
        }
    }

    /**
     * Method to get single post by id
     * @param $id
     * @param $view
     */
    public function get_single($id, $view)
    {
        $role = $this->user_role->dispatch();
        $comments = $this->CommentManager->get_comments_by_post($id);
        $post = $this->manager->get_single_post($id);
        $comment_text = "Vous devez être connecté pour poster un commentaire";
        if(isset($_SESSION['user_id'])) {

            $title = $this->form->inputs([
                'label' => 'Titre',
                'name' => 'title',
                'placeholder' => 'Mon titre',
                'type' => 'text',
                'class' => 'input-title']);
            $content = $this->form->inputs([
                'label' => 'commentaire',
                'name' => 'content',
                'type' => 'text',
                'field' => 'textarea',
                'class' => 'input-content',
                'rows' => 5]);
            $author = $this->form->inputs([
                'label' => 'Commenté par ' . $_SESSION['pseudo'],
                'name' => 'user_id',
                'type' => 'hidden',
                'value' => $_SESSION['user_id']]);
            $post_id = $this->form->inputs([
                'name' => 'post_id',
                'type' => 'hidden',
                'value' => $post->post_id()]);
            $submit = $this->form->inputs([
                'field' => 'button',
                'type' => 'submit',
                'class' => 'btn-primary',
                'placeholder' => 'Commenter']);
        }
        if($view == "front"){
            if(isset($_SESSION['user_id'])){
                $this->render('front/blog-single-post.html.twig', ['post' => $post, 'comments' => $comments, 'post_id' => $post_id, 'title' => $title, 'content' => $content, 'submit' => $submit, 'author' => $author]);
            }
            else{
                $this->render('front/blog-single-post.html.twig', ['post' => $post, 'comments' => $comments, 'comment_text' => $comment_text]);
            }
        }
        elseif($view == "back"){
            if($role == 1){
                $this->render('back/single_post.html.twig', ['post' => $post]);
            } elseif ($role == 0 || $role == 2) {
                $this->acces_denied();
            }
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
            'class' => 'input-title']);
        $author = $this->form->inputs([
            'label' => 'Cet article sera publié par '.$_SESSION['pseudo'],
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => $_SESSION['user_id']]);
        $textarea = $this->form->inputs([
            'field' => 'textarea',
            'name' => 'content',
            'label' => 'Contenu',
            'rows' => 15]);
        $status_input = $this->form->inputs([
            'name' => 'status',
            'type' => 'hidden',
            'label' => '']);
        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn-primary',
            'placeholder' => 'Créer le billet',
            'name' => 'submit',
            'value' => 'add']);
        $draft = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn-success',
            'placeholder' => 'Brouillon',
            'name' => 'submit',
            'value' => 'brouillon']);
        if($role === 1) {
            $this->render('back/add_form.html.twig', ['title' => $title, 'sub' => $subTitle, 'count' => $this->count, 'input' => $input, 'textarea' => $textarea, 'author' => $author, 'submit' => $submit, 'draft' => $draft, 'param' => $param, 'status' => $status_input]);
        } elseif ($role === 0 || $role === 2) {
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

        if($post->status() == 1){
            $status_text = 'Publié';
        }
        elseif ($post->status() == 0){
            $status_text = 'Brouillon';
        }
        $input = $this->form->inputs([
            'label' => 'Mon titre',
            'name' => 'title',
            'type' => 'text',
            'class' => 'input-title',
            'value' => $post->title()]);
        $id_post = $this->form->inputs([
            'name' => 'post_id',
            'type' => 'hidden',
            'value' => $post->post_id()]);
        $textarea = $this->form->inputs([
            'field' => 'textarea',
            'name' => 'content',
            'label' => 'Contenu',
            'rows' => 15,
            'value' => $post->content()]);
        $status_input = $this->form->inputs([
            'name' => 'status',
            'type' => 'hidden',
            'label' => '']);
        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn-primary',
            'placeholder' => 'Mettre à jour',
            'name' => 'submit',
            'value' => 'publier']);
        $draft = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn-success',
            'placeholder' => 'Brouillon',
            'name' => 'submit',
            'value' => 'brouillon']);
        if($role === 1) {
            $this->render('back/add_form.html.twig', ['status_text' => $status_text,'id' => $post_id, 'pseudo' => $pseudo, 'title' => $title, 'sub' => $subTitle, 'count' => $this->count, 'input' => $input, 'textarea' => $textarea, 'submit' => $submit, 'param' => $param, 'post_id' => $id_post, 'status' => $status_input, 'draft' => $draft]);
        } elseif ($role === 0 || $role === 2) {
            $this->acces_denied();
        }

    }

    /**
     * @param $title
     * @param $content
     * @param $user_id
     * @param $status
     */
    private function add_post($title, $content, $user_id, $status){
        $this->post->setTitle($title);
        $this->post->setContent($content);
        $this->post->setStatus($status);
        $this->post->setUserid($user_id);
        $this->manager->create_post($this->post);
    }

    public function create_post(){
        $status = $_POST['status'];
        $post = $_POST;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_POST['user_id'];
        $submit = $_POST['submit'];

        if(!empty($post)){
            $validate = true;
            if (strlen($title) > 80) {
                $validate = false;
                $error = 1;
            }
            if(empty($title)){
                $validate = false;
                $error = 2;
            }
            if (empty($user_id)) {
                $validate = false;
                $error = 3;
            }

            if (empty($content)) {
                $validate = false;
                $error = 4;
            }
            $this->form_valid->get_errors($error);
            if($validate){
                if($submit == 'brouillon'){
                    $status = 0;
                }
                elseif ($submit == 'add'){
                    $status = 1;
                }
                $this->add_post($title, $content, $user_id, $status);
                header('Location: /list-posts');
            } else{
                header('Location: /addPostForm');
            }
        }
    }

    private function post_update($title, $content, $post_id, $status){
        $this->post->setTitle($title);
        $this->post->setContent($content);
        $this->post->setPostid($post_id);
        $this->post->setStatus($status);
        $this->manager->update_post($this->post);
    }


    public function update_post($post_id){
        $status = $_POST['status'];
        $post = $_POST;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $submit = $_POST['submit'];
        $post_id = $this->manager->get_single_post($post_id);

        if(!empty($post)){
            $validate = true;
            if (strlen($title) > 80) {
                $validate = false;
                $error = 1;
            }
            if (empty($title)){
                $validate = false;
                $error = 2;
            }
            if (empty($content)) {
                $validate = false;
                $error = 4;
            }
            $this->form_valid->get_errors($error);
            if($validate){
                if($submit == 'brouillon'){
                    $status = 0;
                } elseif ($submit == 'publier'){
                    $status = 1;
                }
                $this->post_update($title, $content, $post_id, $status);
                header('Location: /list-posts');
            }
        }
    }

    private function update_draft($post_id){
        $this->post->setPostid($post_id);
        $this->manager->drafting($this->post);
    }

    public function draft_post($post_id){
        $post_id = $this->manager->get_single_post($post_id);
        $this->update_draft($post_id);
        header('Location: list-draft');
    }

    public function delete_post($post_id){
        $this->manager->delete($post_id);
        header('Location: /list-posts');
    }
}
