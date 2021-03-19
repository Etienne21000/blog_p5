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

    private $name;

    private $check_user;

    private $password;

    private $check_params;
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
     * @param $user_id
     */
    public function get_user($user_id){
        $title = "bienvenu sur votre profil";
        $sub = "Vous trouverez toutes les informations vous concernant et la possibiliter de modifier votre profil";

        $user = $this->manager->get_single_user($user_id);
        $this->render('back/user_info.html.twig', ['user' => $user, 'title' => $title, 'sub' => $sub]);
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
     * @return array
     * Method to return array of $_POST values
     */
    private function user_params(){
        $user_params = [
            'pseudo' => $_POST['pseudo'],
            'mail' => $_POST['mail'],
            'pass' => $_POST['pass'],
            'confirm_mail' => $_POST['confirm_mail'],
            'confirm_pass' => $_POST['confirm_pass'],
        ];
        return $user_params;
    }

    /**
     * @param $check_params
     */
    public function validate_create_user($check_params){
        $user_pa = $this->user_params();
        if($check_params === true){
            $user_pa['pass'] = password_hash($user_pa['pass'], PASSWORD_BCRYPT);
            $this->add_user($user_pa['pseudo'], $user_pa['mail'], $user_pa['pass']);
            $success = 1;
            $this->form_valid->get_success($success);
            header('Location: /connect_user_view');
        } else {
            header('Location: /create_user');
        }
    }

    /**
     * checking and add user
     */
    public function create_user()
    {
        $user_pa = $this->user_params();
        $this->check_params = false;

        $empty = $this->form_valid->validate($param = [$user_pa['pseudo'], $user_pa['mail'], $user_pa['pass'], $user_pa['confirm_mail'], $user_pa['confirm_pass']], 2, 1);
        $exist_pseudo = $this->valid_pseudo($user_pa['pseudo']);
        $exist_mail = $this->valid_mail($user_pa['mail']);

        if($empty === true){
            $match = $this->form_valid->validate($param = [$match_pseudo = preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $user_pa['pseudo']), $match_pass = preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $user_pa['pass'])], 9, 2);
            if($match === true){
                $equals = $this->form_valid->validate_data($param = [[$user_pa['mail'], $user_pa['confirm_mail']], [$user_pa['pass'], $user_pa['confirm_pass']]], 13, 3);
                if($equals === true){
                    $exist = $this->form_valid->validate_data($param = [$exist_pseudo, $exist_mail], 18, 4);
                    if($exist === true){
                        $this->check_params = true;
                    }
                }
            }
        }
        $this->validate_create_user($this->check_params);
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
     * @param $check_params
     * @param $user
     */
    public function validate_form($check_params, $user){
        if($check_params === true){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['role'] = $user['role'];
            if($user['role'] === 1){
                header('Location: /dashboard');
            } elseif($user['role'] === 0){
                header('Location: /');
            }
        }elseif($check_params === false){
            header('Location: /connect_user_view');
        }
    }

    /**
     * UserConnect method
     */
    public function connect_user() {

        $pseudo = $_POST['pseudo'];
        $pass = $_POST['pass'];
        $user = $this->valid_pseudo($pseudo);
        $check_pass = password_verify($pass, $user['pass']);
        $this->name = $this->form_valid->validate_data($param = [$pseudo, $pass],2,1);

        $this->check_params = false;
        if($this->name === true){
            $this->check_user = $this->form_valid->validate_data($param = [$user], 16, 2);
            if($this->check_user === true){
                $this->password = $this->form_valid->validate_data($param = [$check_pass], 17, 2);
                if($this->password === true){
                    $this->check_params = true;
                }
            }
        }
        $this->validate_form($this->check_params, $user);
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

        $pseudo = $this->form->inputs(['label' => 'Pseudo', 'name' => 'pseudo', 'placeholder' => 'Votre pseudo', 'type' => 'text', 'class' => 'input-pseudo']);

        $mail = $this->form->inputs(['label' => 'Mail', 'name' => 'mail', 'placeholder' => 'Votre mail', 'type' => 'email']);

        $confirm_mail = $this->form->inputs(['label' => 'Confirmez votre mail', 'name' => 'confirm_mail', 'placeholder' => 'Confirmation mail', 'type' => 'email']);

        $pass = $this->form->inputs(['label' => 'Saissisez un mot de passe', 'name' => 'pass', 'placeholder' => 'Votre mot de passe', 'type' => 'password']);

        $confirm_pass = $this->form->inputs(['label' => 'Confirmez votre mot de passe', 'name' => 'confirm_pass', 'placeholder' => 'Confirmation du mot de passe', 'type' => 'password']);

        $submit = $this->form->inputs(['field' => 'button', 'type' => 'submit', 'placeholder' => 'Créer', 'class' => 'btn-primary']);

        $this->render('front/user_form.html.twig', ['param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'mail' => $mail, 'confirm_mail' => $confirm_mail, 'pass' => $pass, 'confirm_pass' => $confirm_pass, 'submit' => $submit]);
    }

    /**
     * Method to get the user connexion view
     */
    public function connect_user_view(){
        $title = 'Se connecter';
        $subTitle = 'Connectez-vous à votre compte utilisateur';
        $param = 'connect';

        $pseudo = $this->form->inputs(['label' => 'Pseudo', 'name' => 'pseudo', 'placeholder' => 'Votre pseudo', 'type' => 'text', 'class' => 'input-pseudo']);

        $pass = $this->form->inputs(['label' => 'Saissisez un mot de passe', 'name' => 'pass', 'placeholder' => 'Votre mot de passe', 'type' => 'password']);

        $submit = $this->form->inputs(['field' => 'button', 'type' => 'submit', 'placeholder' => 'Créer', 'class' => 'btn-primary']);

        $this->render('front/user_form.html.twig', ['param' => $param, 'title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'pass' => $pass, 'submit' => $submit]);
    }

    public function delete_u($user_id){
        $this->manager->delete_user($user_id);
        session_destroy();
        header('Location: /');
        exit();
    }
}
