<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PostManager;
use App\Model\ImageManager;
use App\Model\CommentManager;
use App\Model\UserManager;
use App\Model\Form;



class MasterController extends AbstractController
{
    private $PostManager;
    private $ImageManager;
    private $UserManager;
    private $CommentManager;
    private $form;

    public function __construct()
    {

        $this->PostManager = new PostManager();
        $this->ImageManager = new ImageManager();
        $this->UserManager = new UserManager();
        $this->CommentManager = new CommentManager();
        $this->form = new Form();

    }

    public function index()
    {
        $posts = $this->PostManager->get_all_posts();

        $msg = 'Hello world';

        $title = "Etienne Juffard";
        $subTitle = 'Développeur web php / symfony sans oublier le front !';
        $post_title = "Retrouvez les derniers articles";
        /*$data = array(
            'name' => $title,
            'sub' => $subTitle
        );*/

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

    Public function dashbord()
    {
        $msg = 'Hello';

        $title = "Site web d'Etienne Juffard";
        $subTitle = 'Bienvenu sur mon blog';
        $count = $this->PostManager->testCount();

//        var_dump($count);

        $data = array(
            'name' => $title,
            'sub' => $subTitle
        );

        $this->render('back/index.html.twig', ['msg' => $msg, 'title' => $title, 'sub' => $subTitle, 'count' => $count]);

    }

    public function get_msg()
    {
        $msg = 'Hello';
        $title = "Site web d'Etienne Juffard";
        $subTitle = 'Bienvenu sur mon blog';
        $count = $this->PostManager->testCount();

        var_dump($count);

//        $data = array(
//            'msg' => $msg,
//            'name' => $title,
//                 'sub' => $subTitle
//        );
//
//        $this->render('back/msg.html.twig', ['msg' => $msg, 'title' => $title, 'sub' => $subTitle, 'count' => $count]);

    }

    /*public function count_all_posts()
    {
        $countPosts = $this->PostManager->count();

        return $countPosts;
    }*/
    public function download_cv() {

        $file = "cv.pdf";
        $file_path = $_SERVER['DOCUMENT_ROOT']."/Public/download/$file";

        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
            header('Content-Type: application/pdf');
            header('Content-Length: ' . filesize($file_path));
            //header('Pragma: public');
            readfile($file_path);
            echo $file_path;
            //exit;
        }
        else {
            echo "Le fichier d'origine n'existe pas";
        }

    }
}


