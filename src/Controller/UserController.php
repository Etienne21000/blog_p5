<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\Form;
use App\Model\Form_validation;
use App\Model\UserManager;
use App\Model\User;
use App\Core\User_role;

class UserController extends AbstractController
{
    /**
     * @var UserManager
     */
    private $manager;
    /**
     * @var Form
     */
    private $form;
    /**
     * @var Form_validation
     */
    private $form_valid;
    /**
     * @var User_role
     */
    private $user_role;

    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->manager = new UserManager();
        $this->user = new User([]);
        $this->form = new Form(array());
        $this->form_valid = new Form_validation();
        $this->user_role = new User_role();
    }

    /**
     * @param $pseudo
     * @param $mail
     * @param $pass
     */
    public function add_user($pseudo, $mail, $pass) {

        $this->user->setPseudo($pseudo);
        $this->user->setMail($mail);
        $this->user->setPass($pass);

        $this->manager->create_user($this->user);
    }

    /**
     * checking and add user
     */
    public function create_user()
    {
        if(!empty($_POST)) {

            $validate = true;

//            $user_val = [
//              'pseudo' => $_POST['pseudo'],
//              'mail' => $_POST['mail'],
//              'confirm_mail' => $_POST['confirm_mail'],
//              'pass' => $_POST['pass'],
//              'confirm_pass' => $_POST['confirm_pass']
//            ];

            if (empty($_POST['pseudo']) || strlen($_POST['pseudo']) > 20 || !preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $_POST['pseudo'])) {
                $validate = false;
//                echo "le pseudo est incorrect validate = $validate";
//                exit();
                //$error = 1;
            }

            if (empty($_POST['mail']) || strlen($_POST['mail']) > 50 || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $validate = false;
//                echo "le mail est incorrect";
//                exit();
                //$error = 2;
            }

            if (empty($_POST['confirm_mail']) || ($_POST['mail'] !== $_POST['confirm_mail'])) {
                $validate = false;
//                echo "le mail ne correspond pas à l'adresse indiquée";
//                exit();
                //$error = 3;
            }

            if (empty($_POST['pass']) || strlen($_POST['pass']) > 100 || !preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $_POST['pass'])) {
                $validate = false;
                //$error = 4;
            }

            if (empty($_POST['confirm_pass']) || ($_POST['pass'] !== $_POST['confirm_pass'])) {
                $validate = false;
                //$error = 5;
            }

//            echo password_hash($_POST['pass'], PASSWORD_BCRYPT);
//            exit();

            if ($validate) {

                if (!$this->valid_pseudo($_POST['pseudo']) && !$this->valid_mail($_POST['mail'])) {

                    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

//                    echo $_POST['pass'];
//                    exit();
                    $this->add_user($_POST['pseudo'],
                        $_POST['mail'], $_POST['pass']);

//                    print_r($this->user);
//                    exit();

                    header('Location: /dashboard');

                } else {
                    echo "Le pseudo ou le mail utiliser pour l'inscription éxiste déjà";
//                $error = 5;
                }

            }
        }
    }

    /**
     * @param $pseudo
     * @return mixed
     */
    public function valid_pseudo($pseudo)
    {
        return $this->manager->check_pseudo($pseudo);
//        return $user_check;
    }

    /**
     * @param $mail
     * @return mixed
     */
    public function valid_mail($mail)
    {
        return $this->manager->check_mail($mail);
//        return $mail_check;
    }

//    public function get_user($pseudo)
//    {
//        return $this->manager->check_pseudo($pseudo);
//    }

    /**
     * UserConnect method
     */
    public function connect_user() {

        if (!empty($_POST)){

            $validate = true;

            if (empty($_POST['pseudo']) || empty($_POST['pass']))
            {
//                $erreur = 1;
                $validate = false;
            }

//            if (strlen($_POST['pseudo']) > 20 || strlen($_POST['pass']) > 30)
//            {
////                $error = 2;
//                $validate = false;
//            }

            if($validate){

                $user = $this->valid_pseudo($_POST['pseudo']);

                if(!$user){
                    echo "erreur le pseudo n'héxiste pas";
                }
                else {
                    $check_pass = password_verify($_POST['pass'], $user['pass']);

                    if($check_pass){
                        $_SESSION['id'] = $user['user_id'];
                        $_SESSION['pseudo'] = $user['pseudo'];
                        $_SESSION['role'] = $user['role'];

                        if($user['role'] === 1){
                            header('Location: /dashboard');
                        }
                        elseif($user['role'] === 0){
                            header('Location: /dashboard');
                        }
                    }
                }
            }

        }
    }

    /**
     * Create User method
     */
    public function create_user_view()
    {
        $title = 'Créer un compte';
        $subTitle = 'Ce formulaire vous permet de créer votre compte utilisateur';
        $param = 'create';

        $pseudo = $this->form->inputs([
            'label' => 'Pseudo',
            'name' => 'pseudo',
            'placeholder' => 'Votre pseudo',
            'type' => 'text',
            'class' => 'input-pseudo',
        ]);
        $mail = $this->form->inputs([
            'label' => 'Mail',
            'name' => 'mail',
            'placeholder' => 'Votre mail',
            'type' => 'email'
        ]);
        $confirm_mail = $this->form->inputs([
            'label' => 'Confirmez votre mail',
            'name' => 'confirm_mail',
            'placeholder' => 'Confirmation mail',
            'type' => 'email'
        ]);

        $pass = $this->form->inputs([
            'label' => 'Saissisez un mot de passe',
            'name' => 'pass',
            'placeholder' => 'Votre mot de passe',
            'type' => 'password'
        ]);

        $confirm_pass = $this->form->inputs([
            'label' => 'Confirmez votre mot de passe',
            'name' => 'confirm_pass',
            'placeholder' => 'Confirmation du mot de passe',
            'type' => 'password'
        ]);

        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'placeholder' => 'Créer',
        ]);

        $this->render('front/user_form.html.twig', ['param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'mail' => $mail, 'confirm_mail' => $confirm_mail, 'pass' => $pass, 'confirm_pass' => $confirm_pass, 'submit' => $submit]);
    }

    /**
     *
     */
    public function connect_user_view(){
        $title = 'Se connecter';
        $subTitle = 'Connectez-vous à votre compte utilisateur';
        $param = 'connect';

        $pseudo = $this->form->inputs([
            'label' => 'Pseudo',
            'name' => 'pseudo',
            'placeholder' => 'Votre pseudo',
            'type' => 'text',
            'class' => 'input-pseudo',
        ]);

        $pass = $this->form->inputs([
            'label' => 'Saissisez un mot de passe',
            'name' => 'password',
            'placeholder' => 'Votre mot de passe',
            'type' => 'password'
        ]);

        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'placeholder' => 'Créer',
        ]);

        $this->render('front/user_form.html.twig', ['param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'pass' => $pass, 'submit' => $submit]);
    }

}
