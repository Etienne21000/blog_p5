<?php
namespace App\Controller;

use App\Core\AbstractController;
use App\Model\Form;
use App\Model\Form_validation;
use App\Model\UserManager;

class UserController extends AbstractController
{

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->manager = new UserManager();
        $this->form = new Form(array());
        $this->form_valid = new Form_validation();
    }

    /**
     * Create User method
     */
    public function create_user()
    {
        $title = 'Créer un compte';
        $subTitle = 'Ce formulaire vous permet de créer votre compte utilisateur';

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
            'name' => 'password',
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

        $this->render('front/user_form.html.twig', ['title' => $title, 'sub' => $subTitle, 'pseudo' => $pseudo, 'mail' => $mail, 'confirm_mail' => $confirm_mail, 'pass' => $pass, 'confirm_pass' => $confirm_pass, 'submit' => $submit]);
    }

}
