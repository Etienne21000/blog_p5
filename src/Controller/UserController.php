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

//        $User = new User([]);

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
//        if(!empty($_POST)) {

            $validate = true;

//            $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
//            $_POST['mail'] = htmlspecialchars($_POST['mail']);
//            $_POST['confirm_mail'] = htmlspecialchars($_POST['confirm_mail']);
//            $_POST['pass'] = htmlspecialchars($_POST['pass']);
//            $_POST['confirm_pass'] = htmlspecialchars($_POST['confirm_pass']);

            $user_val = [
              'pseudo' => $_POST['pseudo'],
              'mail' => $_POST['mail'],
              'confirm_mail' => $_POST['confirm_mail'],
              'pass' => $_POST['pass'],
              'confirm_pass' => $_POST['confirm_pass']
            ];

            if (empty($user_val['pseudo']) || strlen($user_val['pseudo']) > 20 || !preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $user_val['pseudo'])) {
                $validate = false;
                echo "le pseudo est incorrect validate = $validate";
                exit();
                //$error = 1;
            }

            if (empty($user_val['mail']) || strlen($user_val['mail']) > 50 || !filter_var($user_val['mail'], FILTER_VALIDATE_EMAIL)) {
                $validate = false;
                echo "le mail est incorrect";
                exit();
                //$error = 2;
            }

            if (empty($user_val['confirm_mail']) || ($user_val['mail'] !== $user_val['confirm_mail'])) {
                $validate = false;
                echo "le mail ne correspond pas à l'adresse indiquée";
                exit();
                //$error = 3;
            }

            if (empty($user_val['pass']) || strlen($user_val['pass']) > 100 || !preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $user_val['pass'])) {
                $validate = false;
                //$error = 4;
            }

            if (empty($user_val['confirm_pass']) || ($user_val['pass'] !== $user_val['confirm_pass'])) {
                $validate = false;
                //$error = 5;
            }

            if ($validate) {

                if (!$this->valid_pseudo($user_val['pseudo']) && !$this->valid_mail($user_val['mail'])) {
                    $user_val['pass'] = password_hash($user_val['pass'], PASSWORD_BCRYPT);

                    $this->add_user($user_val['pseudo'],
                        $user_val['mail'], $user_val['pass']);

                    header('Location: /dashboard');

                } else {
                    echo "Le pseudo ou le mail utiliser pour l'inscription éxiste déjà";
//                $error = 5;
                }

            }
//        }
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
//            'length' => 2,
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
    /*public function connect_user(){
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
    }*/

}
