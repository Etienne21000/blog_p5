<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\CommentManager;
use App\Model\Form;
use App\Model\Form_validation;
use App\Model\Comment;
use App\Core\User_role;
use App\Model\PostManager;

class CommentController extends AbstractController
{

    private $manager;
    private $form;
    private $form_valid;
    private $comment;
    private $user_role;
    private $postManager;

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->manager = new CommentManager();
        $this->form = new Form(array());
        $this->form_valid = new Form_validation();
        $this->user_role = new User_role();
        $this->comment = new Comment([]);
        $this->postManager = new PostManager();
    }

    /**
     * @param $user_id
     * @param $title
     * @param $content
     * @param $post_id
     */
    private function create_comment($user_id, $title, $content, $post_id)
    {
        $this->comment->setUserid($user_id);
        $this->comment->setTitle($title);
        $this->comment->setContent($content);
        $this->comment->setPostid($post_id);

        $this->manager->add_comment($this->comment);
    }

    /**
     * @param $post_id
     */
    public function add_comment($post_id){

        $post = $_POST;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = $_POST['user_id'];
        $post_id = $_POST['post_id'];

        unset($_SESSION['error']);

        if(!empty($post)){
            $validate = true;

            if (strlen($title) > 40) {
                $validate = false;
                $error = 1;
            }

            if(empty($title)){
                $validate = false;
                $error = 2;
            }

            if (strlen($content) > 500) {
                $validate = false;
                $error = 5;
            }

            if(empty($content)){
                $validate = false;
                $error = 6;
            }

            $this->form_valid->get_errors($error);

            if($validate){

                $this->create_comment($user_id, $title, $content, $post_id);

                header('Location: /singlePost/'.$post_id);
            }
            else{
                header('Location: /singlePost/'.$post_id);
            }
        }
    }

    public function get_all(){

        $role = $this->user_role->dispatch();

        $Comments = $this->manager->get_all_commennts();
        $title = "Liste de tous les commentaires postés";
        $sub = "Vous pouvez valider ou supprimer les commentaires avant leur publication sur le site";

        if($role == 1){
            $this->render('back/all_comments_view.html.twig',['comments' => $Comments, 'title' => $title, 'sub' => $sub]);

        }elseif ($role == 2 || $role == 0){
            $this->acces_denied();
        }

    }

    public function validate_com($id){
        $this->comment->setId($id);
        $this->manager->validate_comment($this->comment);

        header('Location: /all_comments');
    }

    public function delete_com($id){
        $this->manager->delete_comment($id);

        header('Location: /all_comments');
    }

}
