<?php
namespace App\Model;

use App\Model\Form;

class Form_validation
{
    private $data;
    private $form;
    private $params;
    private $errors = [];
    private $length;
    private $value;

    private $error_message;

    private $param;
    private $format;

//    public function __construct($data = array())
//    {
//        $this->data = $data;
//    }

//    private function is_valid($values)
//    {
//        return isset($this->data[$values]) ? $this->data[$values] : null;
//    }

    public function is_valid($params = [])
    {
        $params[] = $this->set_validation();

//        $this->length = $params['length'] ?? '';
        $this->length = 4;
    }

    public function set_validation()
    {
        $this->form = new Form(array());

        $value[] = $this->form->set_params();
        return $form_validation = [
            'length' => $this->max_length($value['name'], $this->length),
//            'format' => $this->is_valid($this->format),
        ];

    }

    public function max_length($value, $length)
    {
        $this->length = (int)$length;
        $this->value = $value;

        if(is_string($this->value))
        {
            if(strlen($this->value) < $this->length)
            {
                /*Prévoir des messages flash*/
                echo "Le champs $this->value doit contenir au minimum $this->length caractères";
            }
            else
            {
                echo "Le champ $this->value contient le bon nombre de caractères";
//                return $this->length = true;
            }
        }
        else
        {
            echo "Le champ $this->value ne peut pas être un nombre";
        }
    }

//    public function __construct(array $params)
//    {
//        $this->params = $params;
////        $this->error_message = $error_message;
//    }
//
//    public function is_valid($value)
//    {
//        return strlen($value) <= $this->length;
//    }
//
//    public function set_error_message($error_message)
//    {
//        if(is_string($error_message))
//        {
//            $this->error_message = $error_message;
//        }
//    }
//
//    public function get_error_message()
//    {
//        return $this->error_message;
//    }
//
//    public function max_length($length)
//    {
//        $length = (int) $length;
//
//        if($length > 0)
//        {
//            $this->length = $length;
//        }
//        else
//        {
//            echo "La valeur ne peut pas être égale à 0";
//        }
//    }

    /**
     * @param string $fields
     * @return $this
     */
//    public function form_val(string ...$fields): self
//    {
//        $this->params = $_POST;
//        foreach ($fields as $field)
//        {
//            if(!array_key_exists($field, $this->params))
//            {
//                $this->errors[$field] = "Attention le champ $field n'est pas valide";
////                var_dump($this->params);
//            }
//        }
//        return $this;
//    }
//
//    public function form_errors(): array
//    {
//        return $this->errors;
//    }
//
//    public function field_lenhtg(int $length, string ...$fields): self
//    {
//        $this->length = $length;
//        $this->params = $_POST;
//        foreach ($fields as $field)
//        {
//            if($field && $this->params <= (int)$this->length)
//            {
//                $this->errors[$field] = "Attention le champ $field doit contenir au minimum $this->length caractères.";
//            }
//        }
//
//        return $this;
//    }
//
//    public function get_length($length, $param): self
//    {
//        $this->length = (int)$length;
//        $this->param = (string)$param;
//
//        if($this->length < $this->param)
//        {
//            echo "error, field must be $length long";
//        }
//
//        return $this;
//    }
}