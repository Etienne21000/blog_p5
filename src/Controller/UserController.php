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
     * @var array
     */
    private $errors = [];

    /**
     * @var MasterController
     */

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
        $post = $_POST;
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        $pass = $_POST['pass'];
        $confirm_mail = $_POST['confirm_mail'];
        $confirm_pass = $_POST['confirm_pass'];

        if(!empty($post)) {

            $validate = true;

            if (empty($pseudo)) {
                $validate = false;
                $error = 2;
            }
            if(strlen($pseudo) > 20){
                $validate = false;
                $error = 8;
            }
            if(!preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $pseudo)){
                $validate = false;
                $error = 9;
            }
            if (empty($mail)) {
                $validate = false;
                $error = 2;
            }
            if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
                $validate = false;
                $error = 11;
            }
            if (empty($confirm_mail)) {
                $validate = false;
                $error = 2;
            }
            if(($mail !== $confirm_mail)){
                $validate = false;
                $error = 13;
            }
            if (empty($pass)) {
                $validate = false;
                $error = 2;
            }
            if(strlen($pass) > 20){
                $validate = false;
                $error = 14;
            }
            if(!preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $pass)){
                $validate = false;
                $error = 15;
            }
            if (empty($confirm_pass)) {
                $validate = false;
                $error = 2;
            }
            if(($pass !== $confirm_pass)){
                $validate = false;
                $error = 13;
            }
            if($this->valid_pseudo($pseudo) && $this->valid_mail($mail)){
                $validate = false;
                $error = 18;
            }
            $this->form_valid->get_errors($error);
            if($validate === true){
                $pass = password_hash($pass, PASSWORD_BCRYPT);
                $this->add_user($pseudo, $mail, $pass);
                $success = 1;
                $this->form_valid->get_success($success);
                header('Location: /connect_user_view');
            } else {
                header('Location: /create_user');
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

        $post = $_POST;
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['pass'];

        if (!empty($post)){
            $validate = true;

            if (empty($pseudo))
            {
                $error = 2;
                $validate = false;
            }
            if(empty($pass)){
                $error = 2;
                $validate = false;
            }
            $user = $this->valid_pseudo($pseudo);
            if($user){
                $validate = true;
                $check_pass = password_verify($pass, $user['pass']);
                if(!$check_pass){
                    $error = 17;
                    $validate = false;
                }
                elseif($check_pass){
                    $validate = true;
                    session_start();
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['pseudo'] = $user['pseudo'];
                    $_SESSION['role'] = $user['role'];
                }
            }
            elseif(!$user){
                $error = 16;
                $validate = false;
            }
            $this->form_valid->get_errors($error);
            if($validate){
                if($user['role'] === 1){
                    header('Location: /dashboard');
                    exit();
                } elseif($user['role'] === 0){
                    header('Location: /');
                    exit();
                }
            } else {
                header('Location: /connect_user_view');
            }
        }
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
            'class' => 'input-pseudo']);
        $mail = $this->form->inputs([
            'label' => 'Mail',
            'name' => 'mail',
            'placeholder' => 'Votre mail',
            'type' => 'email']);
        $confirm_mail = $this->form->inputs([
            'label' => 'Confirmez votre mail',
            'name' => 'confirm_mail',
            'placeholder' => 'Confirmation mail',
            'type' => 'email']);
        $pass = $this->form->inputs([
            'label' => 'Saissisez un mot de passe',
            'name' => 'pass',
            'placeholder' => 'Votre mot de passe',
            'type' => 'password']);
        $confirm_pass = $this->form->inputs([
            'label' => 'Confirmez votre mot de passe',
            'name' => 'confirm_pass',
            'placeholder' => 'Confirmation du mot de passe',
            'type' => 'password']);
        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'placeholder' => 'Créer',
            'class' => 'btn-primary']);
        $this->render('front/user_form.html.twig', ['param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'mail' => $mail, 'confirm_mail' => $confirm_mail, 'pass' => $pass, 'confirm_pass' => $confirm_pass, 'submit' => $submit]);
    }

    /**
     * Method to get the user connexion view
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
            'class' => 'input-pseudo']);
        $pass = $this->form->inputs([
            'label' => 'Saissisez un mot de passe',
            'name' => 'pass',
            'placeholder' => 'Votre mot de passe',
            'type' => 'password']);
        $submit = $this->form->inputs([
            'field' => 'button',
            'type' => 'submit',
            'placeholder' => 'Créer',
            'class' => 'btn-primary']);
        $this->render('front/user_form.html.twig', ['param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'pass' => $pass, 'submit' => $submit]);
    }
}
