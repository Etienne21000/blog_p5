<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\Form;
use App\Model\Form_validation;
use App\Model\UserManager;
use App\Model\User;
use App\Core\User_role;
use App\Controller\MasterController;

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
     * @var array
     */
    private $errors = [];

    /**
     * @var MasterController
     */
    private $master;

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
        $this->master = new MasterController();
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
//        $error = null;

        if(!empty($_POST)) {

            $validate = true;

            if (empty($_POST['pseudo']) || strlen($_POST['pseudo']) > 20 || !preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $_POST['pseudo'])) {
                $validate = false;
                $error = 1;
            }

            if (empty($_POST['mail']) || strlen($_POST['mail']) > 50 || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $validate = false;
                $error = 2;
            }

            if (empty($_POST['confirm_mail']) || ($_POST['mail'] !== $_POST['confirm_mail'])) {
                $validate = false;
                $error = 3;
            }

            if (empty($_POST['pass']) || strlen($_POST['pass']) > 20 || !preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $_POST['pass'])) {
                $validate = false;
                $error = 4;
            }

            if (empty($_POST['confirm_pass']) || ($_POST['pass'] !== $_POST['confirm_pass'])) {
                $validate = false;
                $error = 5;
            }

            if ($validate) {

                if (!$this->valid_pseudo($_POST['pseudo']) && !$this->valid_mail($_POST['mail'])) {

                    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

                    $this->add_user($_POST['pseudo'],
                        $_POST['mail'], $_POST['pass']);

                    header('Location: /dashboard');

                } else {
                $error = 6;
                }

            }
        }
        //$this->get_errors($error);
    }

    /**
     * @param $pseudo
     * @return mixed
     */
    public function valid_pseudo($pseudo)
    {
        return $this->manager->check_pseudo($pseudo);
    }

    /**
     * @param $mail
     * @return mixed
     */
    public function valid_mail($mail)
    {
        return $this->manager->check_mail($mail);
    }

    /**
     * UserConnect method
     */
    public function connect_user() {

        //$error = null;

        if (!empty($_POST)){

            $validate = true;

            if (empty($_POST['pseudo']) || empty($_POST['pass']))
            {
                $errors = 7;
                $validate = false;
            }

            if($validate === true){

                $user = $this->valid_pseudo($_POST['pseudo']);

                if(!$user){
                    $errors = 8;
                }
                else {
                    $check_pass = password_verify($_POST['pass'], $user['pass']);
                    if($check_pass){
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['pseudo'] = $user['pseudo'];
                        $_SESSION['role'] = $user['role'];

                        if($user['role'] === 1){
                            header('Location: /dashboard');
                            exit();
                        }
                        elseif($user['role'] === 0){
                            header('Location: /dashboard');
                            exit();
                        }
                    }
                    else{
                        $errors = 9;
                    }
                }
            }
        }
        //$this->get_errors($this->errors);
    }

    /**
     * method to disconnect user
     */
    public function disconnect_user()
    {
        session_destroy();

        header('Location: /');
        exit();
    }

    /**
     * @param array $errors
     * @return string
     */
    public function get_errors(array $errors){

        $this->errors = $errors;
        $error = null;

        switch ($error)
        {
            case 1:
                $error = '* Le champ pseudo est vide ou invalide : il doit contenir ...';
                var_dump($error);
                exit();
                break;

            case 2:
                $error = '* Le format du mail est incorrect';
                var_dump($error);
                exit();
                break;

            case 3:
                $error = '* Veuillez réessayer de confirmer votre email';
                var_dump($error);
                exit();
                break;

            case 4:
                $error = '* Attention le mot de passe est incorrect : il doit contenir au moins ...';
                var_dump($error);
                exit();
                break;

            case 5:
                $error = '* Veuillez réessayer de confirmer votre mot de passe';
                var_dump($error);
                exit();
                break;

            case 6:
                $error = '* Le pseudo ou le mail utiliser pour l\'inscription éxiste déjà';
                var_dump($error);
                exit();
                break;

            case 7:
                $error = '* Vous devez remplir tous les champs';
                var_dump($error);
                exit();
                //header('Location: connect_user_view');
                break;

            case 8:
                $error = '* erreur le pseudo n\'héxiste pas';
                var_dump($error);
                exit();
                break;

            case 9:
                $error = '* le mot de passe est incorrect';
                var_dump($error);
                exit();
                break;
        }
        $errors[] = $error;
        return $error;
        //$this->connect_user_view();
    }

    /**
     * Create User method
     */
    public function create_user_view()
    {
        $title = 'Créer un compte';
        $subTitle = 'Ce formulaire vous permet de créer votre compte utilisateur';
        $param = 'create';
        $error = null;

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
            'class' => 'btn-primary',
        ]);

        $this->render('front/user_form.html.twig', ['error' => $error, 'param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'mail' => $mail, 'confirm_mail' => $confirm_mail, 'pass' => $pass, 'confirm_pass' => $confirm_pass, 'submit' => $submit]);
    }

    /**
     *
     */
    public function connect_user_view(){
        $title = 'Se connecter';
        $subTitle = 'Connectez-vous à votre compte utilisateur';
        $param = 'connect';
        $error = null;

        $this->get_errors($this->errors);

        $pseudo = $this->form->inputs([
            'label' => 'Pseudo',
            'name' => 'pseudo',
            'placeholder' => 'Votre pseudo',
            'type' => 'text',
            'class' => 'input-pseudo',
        ]);

        $pass = $this->form->inputs([
            'label' => 'Saissisez un mot de passe',
            'name' => 'pass',
            'placeholder' => 'Votre mot de passe',
            'type' => 'password'
        ]);

        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'placeholder' => 'Créer',
            'class' => 'btn-primary',
        ]);

        $this->render('front/user_form.html.twig', ['error' => $error, 'param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'pass' => $pass, 'submit' => $submit]);
    }

}
