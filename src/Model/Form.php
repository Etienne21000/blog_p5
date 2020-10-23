<?php
namespace App\Model;

use App\Model\Post;
use App\Model\Comment;
use App\Model\User;
use App\Core\Router;
use App\Model\Form_validation;

class Form
{

    private $data;
    private $p = 'p';
    private $fields;
    private $label;
    private $for;
    private $name;
    private $placeholder;
    private $class;
    private $id;
    private $title;
    private $type;
    private $value;
    private $field;
    private $rows;
    private $validation;
    private $length;

    public function __construct($data = array())
    {
        $this->data = $data;
//        $this->validation = $this->validation = new Form_validation();

//        $this->validation = new Form_validation(array(), $errors = "");
    }

//    public function form($val = array())
//    {
//
//    }

    /**
     * @param $html
     * @return string
     */
    private function surround($html)
    {
        return "<{$this->p}>{$html}</{$this->p}>";
    }

    /**
     * @param $index
     * @return mixed|null
     */
    private function values($index)
    {
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

//    private function check_valid()
//    {
//        $this->validation = new Form_validation();
//
//
//
//    }

    /**
     * Add all needed fields such as select / checkBox / radio etc.
     * @param array $params
     * @return string
     */
    public function inputs($params = [])
    {
        $params[] = $this->set_params();
//        $valid[] = $this->validation->set_validation();


        $this->placeholder = $params['placeholder'] ?? '';
        $this->name = $params['name'] ?? 'default';
        $this->label = $params['label'] ?? 'label required';
        $this->type = $params['type'] ?? '';
        $this->class = $params['class'] ?? '';
        $this->field = $params['field'] ?? 'input';
        $this->rows = $params['rows'] ?? '';
//        $this->length = $valid['length'] ?? '';

        switch ($this->field)
        {
            case 'input':
                return $this->surround('
                <label for="' .$this->name.'">' . $this->label.'</label><br>
                <'.$this->field . ' name="' . $this->name.'" type="'.$this->type.'" class="form-control ' . $this->class.'" value="" placeholder="' . $this->placeholder . '">');
                break;
            case 'textarea':
                return $this->surround('
                <label for="' .$this->name. '">'.$this->label.'</label><br>
                <'.$this->field.' name="' .$this->name. '" type="'.$this->type.'" class="form-control ' . $this->class . '" rows="'.$this->rows.'" value="">'.$this->placeholder.'</'.$this->field.'>');
                break;
            case 'button':
                return $this->surround('<'.$this->field.' type="'.$this->type.'" class="btn btn-primary '.$this->class.'">'.$this->placeholder.'</'.$this->field.'>');
                break;
        }
    }

    /**
     * @return array
     */
    public function set_params()
    {
        return $form_params = [
//            array(
                'label' => $this->values($this->label),
                'for' => $this->values($this->for),
                'name' => $this->values($this->name),
                'placeholder' => $this->values($this->placeholder),
                'class' => $this->values($this->class),
                'id' => $this->values($this->id),
                'title' => $this->values($this->title),
                'type' => $this->values($this->type),
                'value' => $this->values($this->value),
                'field' => $this->values($this->field),
                'rows' => $this->values($this->rows),
//            ),
//            array(
//                'length' => $this->is_valid($this->length),
//            )
        ];
    }
}