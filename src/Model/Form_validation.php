<?php
namespace App\Model;

class Form_validation
{
    public function get_errors($err){

        $errors = [
            1 => 'Attention le contenu de votre titre est trop long',
            2 => 'Attention vous devez renseigner un titre',
            3 => 'Aucun identifiant valide pour cet utilisateur',
            4 => 'Attention le contenu de votre article est vide',
            5 => 'Attention le contenu de votre commentaire est trop long',
            6 => 'Attention le contenu de votre commentaire est vide',
        ];

        if($_SESSION['error']){
            unset($_SESSION['error']);
        }

        $_SESSION['error'] = $err;

        $error = $err;

        foreach ($errors as $key => $value){
            if($key == $error){

                $resp = $value;
                unset($_SESSION['error']);

                $_SESSION['error'] = $resp;
            }
        }
    }

    /**
     * @param array $errors
     * @return string
     */
    /*public function get_error(array $errors){

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
    }*/
}