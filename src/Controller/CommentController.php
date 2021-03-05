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
    private $count;
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

        $post_id = $this->postManager->get_single_post($post_id);

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

            if($validate){

                $this->create_comment($_POST['user_id'], $_POST['title'], $_POST['content'], $_POST['post_id']);

                header('Location: /list-posts');
            }
        }
    }

}
