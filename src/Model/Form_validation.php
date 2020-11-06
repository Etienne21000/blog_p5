<?php
namespace App\Model;

use App\Model\Form;

class Form_validation
{
    private $errors = [];
    private $valid;
    private $string;
    private $post_values = [];
    private $int;
    private $title;
    private $pseudo;

    public function get_error($field)
    {
        return isset($this->errors[$field]) ? $this->errors['field'] : '';
    }

    public function set_errors(array $errors)
    {
        $this->errors = $errors;
        foreach ($_POST as $name => $value) {
            $this->errors = [
                'length' => "Le champ est invalide, $name <br> Vous devez saisir au moins deux caractères <br>",
                'empty' => "Le champ $name ne peut pas être vide <br>",
            ];
        }

        return $this->errors;
    }

    public function set_valid($valid)
    {
        $this->valid = $valid;
        foreach ($_POST as $name => $value) {
            return "Le champ $name est valide : $value <br>";
        }

        return $this->valid;
    }

    public function validate()
    {
        if(isset($_POST))
        {
            $this->check_string($this->string);
//            $this->check_int($this->param);
        }
    }

//    private function post_values(array $post_values)
//    {
//        $this->post_values = $post_values;
//        $this->post_values = [
//            'string' => array(
//                'title' => $_POST['title'],
//                'pseudo' => $_POST['pseudo'],
//                'content' => $_POST['content'],
//            ),
//
//            'int' => array(
//                'integer' => $_POST['integer'],
//            )
//        ];
//        return $post_values;
//    }

    private function check_string($string)
    {
        $this->string = (string)$string;
        $errors = $this->set_errors($this->errors);
        $valid = $this->set_valid($this->valid);

        foreach ($_POST as $name => $value)
        {
            if (strlen($value) <= 2 && !empty($value)) {
                echo $errors['length'];
            } elseif (empty($value)) {
                echo $errors['empty'];
            } else {
                echo $valid;
            }
        }
    }

    private function check_int($param)
    {
        $this->param = is_numeric($param);

        foreach ($_POST as $name => $value)
        {
            if(ctype_digit($value))
            {
                echo "Le champ $name est invalide, <br> Il doit s'agir d'un nombre <br>";
            }

            if(empty($value))
            {
                echo "Le champ $name ne peut pas être vide <br>";
            }
        }
    }
}