<?php
namespace App\Model;

class Form_validation
{
    public function get_errors($err){

        $errors = [
            1 => 'Attention, le contenu de votre titre est trop long',
            2 => 'Attention, vous devez renseigner ce champ',
            3 => 'Aucun identifiant valide pour cet utilisateur',
            4 => 'Attention le contenu de votre article est vide',
            5 => 'Attention le contenu de votre commentaire est trop long',
            6 => 'Attention le contenu de votre commentaire est vide',
            //7 => 'Attention le pseudo est vide',
            8 => 'Attention, votre pseudo ne doit pas dépasser 20 caractères',
            9 => 'Attention, votre pseudo ne peut contenir que des lettres et des chiffres',
            //10 => 'Attention, vous devez renseigner votre email',
            11 => 'Attention, le format de votre email est invalide',
            12 => 'Attention, vous devez confirmer votre adresse email',
            13 => 'Attention, la confirmation ne correspond pas',
            14 => 'Attention, votre mot de passe doit contenir 20 caractères maximum',
            15 => 'Attention, votre mot de passe doit contenir des lettres, chiffres et cractères spéciaux',
            16 => 'Attention, cet utilisateur est inconnu',
            17 => 'Attention, mauvais mot de passe',
            18 => 'Attention ce pseudo ou ce mail est déjà rattaché à un compte',
        ];

        if($_SESSION['error']){
            unset($_SESSION['error']);
        }
        else {
            $_SESSION['error'] = $err;
            $error = $err;

            foreach ($errors as $key => $value) {
                if ($key == $error) {

                    $resp = $value;
                    unset($_SESSION['error']);

                    $_SESSION['error'] = $resp;
                }
            }
        }
    }

    public function get_success($suc){
        $successes = [
            1 => 'Votre compte à bien été créé',
            2 => 'Votre article à bien été posté',
            3 => 'Votre commentaire à bien été ajouté, et doit être validé par l\'administrateur',
        ];

        if($_SESSION['success']){
            unset($_SESSION['success']);
        }
        else{
            $_SESSION['success'] = $suc;
            $success = $suc;

            foreach ($successes as $key => $value){
                if($key == $success) {
                    $resp = $value;
                    unset($_SESSION['success']);

                    $_SESSION['success'] = $resp;
                }
            }
        }
    }
}