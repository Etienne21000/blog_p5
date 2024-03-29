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
    private $check_params;

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

    private function comment_params(){
        $post_params = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'user_id' => $_POST['user_id'],
            'post_id' => $_POST['post_id']
        ];
        return $post_params;
    }

    private function validate_comment($check_params, $post_id){
        $post = $this->comment_params();
        if($check_params === true){
            $this->create_comment($post['user_id'], $post['title'], $post['content'], $post['post_id']);
            $success = 3;
            $this->form_valid->get_success($success);
            header('Location: /singlePost/'.$post_id);
        }
        else{
            header('Location: /singlePost/'.$post_id);
        }
    }

    /**
     * Method to check all posted parameters
     */
    public function add_comment(){

        $post = $this->comment_params();
        $this->check_params = false;
        $empty = $this->form_valid->validate($param = [$post['title'], $post['content']], 2, 1);

        if($empty === true){
            $this->check_params = true;
            $title_length = $this->form_valid->validate_str_length($param = [$post['title']], 40, 20, 5);
            if($title_length === true){
                $content_length = $this->form_valid->validate_str_length($param = [$post['content']], 500, 21, 5);
                if($content_length === true){
                    $this->check_params = true;
                }
            }
        }
        $this->validate_comment($this->check_params, $post['post_id']);
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
