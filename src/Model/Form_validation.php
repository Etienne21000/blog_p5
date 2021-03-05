<?php
namespace App\Model;

use App\Model\Form;

class Form_validation
{
//    private $title_length;
//    private $title_empty;
//    private $content_length;
//    private $content_empty;

    /*private function set_errors(){
        $set_errors = [];
        $this->title_length = 'Attention le contenu de votre titre est trop long';
        $this->title_empty = 'Attention vous devez renseigner un titre';
        $this->content_length = 'Aucun identifiant valide pour cet utilisateur';
        $this->content_empty = 'Attention le contenu de votre article est vide';

        $set_errors[] = $this->title_length;
        $set_errors[] = $this->title_empty;
        $set_errors[] = $this->content_length;

        return $set_errors;
    }*/

    public function get_errors($err){

        $errors = [
            1 => 'Attention le contenu de votre titre est trop long',
            2 => 'Attention vous devez renseigner un titre',
            3 => 'Aucun identifiant valide pour cet utilisateur',
            4 => 'Attention le contenu de votre article est vide',
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
}