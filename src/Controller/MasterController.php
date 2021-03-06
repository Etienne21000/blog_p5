<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;
use App\Model\ImageManager;
use App\Model\CommentManager;
use App\Model\UserManager;
use App\Model\Form;
use App\Core\User_role;

class MasterController extends AbstractController
{
    private $PostManager;
    private $ImageManager;
    private $UserManager;
    private $CommentManager;
    private $form;

    private $user_role;

    public function __construct()
    {
        $this->PostManager = new PostManager();
        $this->ImageManager = new ImageManager();
        $this->UserManager = new UserManager();
        $this->CommentManager = new CommentManager();
        $this->form = new Form();
        $this->user_role = new User_role();
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
            'name' => 'form-control',
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

        $role = $this->user_role->dispatch();
        $msg = 'Hello';
        $title = "Bonjour ";
        $subTitle = 'Bienvenu sur mon blog';

        if($role === 1){
            $this->render('back/index.html.twig', ['count' => $count_post, 'msg' => $msg, 'title' => $title, 'sub' => $subTitle]);
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

    /**
     * Method to get error view
     */
    public function error(){
        //if (http_response_code() != '200'){
            $this->error_view();
//        }
    }
}


