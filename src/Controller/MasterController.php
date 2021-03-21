<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;
use App\Model\ImageManager;
use App\Model\CommentManager;
use App\Model\UserManager;
use App\Model\Form;
use App\Core\User_role;
use App\Model\Form_validation;

class MasterController extends AbstractController
{
    private $PostManager;
    private $ImageManager;
    private $UserManager;
    private $CommentManager;
    private $form;
    private $form_valid;

    private $user_role;

    public function __construct()
    {
        $this->PostManager = new PostManager();
        $this->ImageManager = new ImageManager();
        $this->UserManager = new UserManager();
        $this->CommentManager = new CommentManager();
        $this->form = new Form();
        $this->user_role = new User_role();
        $this->form_valid = new Form_validation();
    }

    public function index()
    {
        $posts = $this->PostManager->get_all_posts($where = 1, $start = 0, $limit = 3);

        $msg = 'Hello world';

        $title = "Etienne Juffard";
        $subTitle = 'Développeur web php / symfony sans oublier le front !';
        $post_title = "Retrouvez les derniers articles";

        $nom = $this->form->inputs([
            'label' => 'Votre nom*',
            'name' => 'nom',
            'placeholder' => 'Votre nom',
            'type' => 'text',
            'class' => 'form-control'
        ]);

        $mail = $this->form->inputs([
            'label' => 'Email*',
            'name' => 'mail',
            'placeholder' => 'Votre email',
            'type' => 'email',
            'class' => 'form-control'
        ]);

        $content = $this->form->inputs([
            'field' => 'textarea',
            'label' => 'Votre demande*',
            'name' => 'content',
            'class' => 'input-name',
            'rows' => 10
        ]);

        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'class' => 'btn btn-primary',
            'placeholder' => 'Envoyer',
        ]);


        $this->render('front/home.html.twig', ['nom' => $nom, 'mail' => $mail, 'content' => $content, 'submit' => $submit, 'posts' => $posts, 'post_title' => $post_title, 'msg' => $msg, 'title' => $title, 'sub' => $subTitle]);
    }

    private function count_posts(){
        $count = [
            'published' => $this->PostManager->count_posts('status = 1'),
            'drafted' => $this->PostManager->count_posts('status = 0'),
        ];

        return $count;
    }

    Public function dashbord()
    {
        $count_post = $this->count_posts();

        $posts = $this->PostManager->get_all_posts($where=1);

        $role = $this->user_role->dispatch();
        $msg = 'Hello';
        $title = "Bonjour ";
        $subTitle = 'Bienvenu sur mon blog';

        if($role === 1){
            $this->render('back/index.html.twig', ['posts' => $posts,'count' => $count_post, 'msg' => $msg, 'title' => $title, 'sub' => $subTitle]);
        }
        elseif ($role === 0){
            $this->index();
        }
        elseif ($role === 2)
        {
            $this->acces_denied();
        }

    }

    /**
     * Method to download cv from home page
     */
    public function download_cv() {

        $file = "cv.pdf";
        $file_path = $_SERVER['DOCUMENT_ROOT']."/Public/download/$file";

        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
            header('Content-Type: application/pdf');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            echo $file_path;
        }
        else {
            echo "Le fichier d'origine n'existe pas";
        }

    }

    public function send_mail(){
        $name = $_POST['nom'];
        $mail = $_POST['mail'];
        $content = $_POST['content'];
        $to = 'etiennejuffard@gmail.com';
        $objet = 'Nouvelle demande de '. $name;
        $headers = array(
            'From' => $mail,
            'Reply-To' => $mail,
            'X-Mailer' => 'PHP/' . phpversion()
        );

        unset($_SESSION['error']);

        if(!empty($name) && !empty($content) && !empty($mail)){
            if(mail($to, $objet, $content, $headers)){
                $success = 4;
                $this->form_valid->get_success($success);
                header('Location: /');
            }
            else{
                $error = 19;
                $this->form_valid->get_errors($error);
                header('Location: /');
            }
        }
        else{
            $error = 2;
            $this->form_valid->get_errors($error);
            header('Location: /');
        }

    }

    /**
     * Method to get error view
     */
    public function error(){
            $this->error_view();
//        }
    }
}


