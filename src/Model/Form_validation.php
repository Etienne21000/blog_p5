<?php
namespace App\Model;

class Form_validation
{
    public function get_errors($err){

        $errors = [
            2 => 'Attention, vous devez renseigner tous les champs',
            8 => 'Attention, votre pseudo ne doit pas dépasser 20 caractères',
            9 => 'Attention, votre pseudo ou votre mot de passe ne respectent pas le format standard',
            13 => 'Attention, la confirmation de votre mail ou de votre mot de passe ne correspond pas',
            14 => 'Attention, votre mot de passe doit contenir 20 caractères maximum',
            15 => 'Attention, votre mot de passe doit contenir des lettres, chiffres et cractères spéciaux',
            16 => 'Attention, cet utilisateur est inconnu',
            17 => 'Attention, mauvais mot de passe',
            18 => 'Attention ce pseudo ou ce mail est déjà rattaché à un compte',
            19 => 'Attention, impossible d\'envoyer votre email',
            20 => 'Attention le titre ne doit pas dépasser 40 caractères',
            21 => 'Attention, Le contenu de votre commentaire ne doit pas dépasser 500 caractères',
        ];

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

    public function get_success($suc){
        $successes = [
            1 => 'Votre compte à bien été créé',
            2 => 'Votre article à bien été posté',
            3 => 'Votre commentaire à bien été ajouté, et doit être validé par l\'administrateur',
            4 => 'Votre mail à bien été envoyé.'
        ];

        unset($_SESSION['error']);
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

    public function validate($param, $e, $type){
        $validate = true;
        if($type === 1) {
            foreach($param as $data) {
                if (empty($data)) {
                    $error = $e;
                    $this->get_errors($error);
                    $validate = false;
                }
            }
        }elseif ($type === 2){
            foreach($param as $data) {
                if (!$data) {
                    $error = $e;
                    $this->get_errors($error);
                    $validate = false;
                }
            }
        }
        return $validate;
    }

    public function validate_data($param, $e, $type){
        $validate = true;
        if($type === 3){
            foreach($param as $data) {
                if ($data[0] !== $data[1]) {
                    $error = $e;
                    $this->get_errors($error);
                    $validate = false;
                }
            }
        } elseif ($type === 4){
            foreach($param as $data) {
                if($data) {
                    $error = $e;
                    $this->get_errors($error);
                    $validate = false;
                }
            }
        }
        return $validate;
    }

    public function validate_str_length($param, $length, $e, $type){
        $validate = true;
        if($type === 5){
            foreach($param as $data) {
                if (strlen($data) > $length) {
                    $error = $e;
                    $this->get_errors($error);
                    $validate = false;
                }
            }
        }
        return $validate;
    }
}