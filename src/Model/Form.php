<?php
namespace App\Model;

use App\Model\Post;
use App\Model\Comment;
use App\Model\User;
use App\Core\Router;
use App\Model\Form_validation;

class Form
{

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $p = 'p';

    /**
     * @var
     */
    private $label;

    /**
     * @var
     */
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
    private $option;
    private $option_fields = [];
    private $text;
    private $validation;
    private $length;

    public function __construct($data = array())
    {
        $this->data = $data;
    }

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

    /**
     * Add all needed fields such as select / checkBox / radio etc.
     * @param array $params
     * @return string
     */
    public function inputs($params = [])
    {
        $params[] = $this->set_params();
        $this->placeholder = $params['placeholder'] ?? '';
        $this->name = $params['name'] ?? 'default';
        $this->label = $params['label'] ?? 'label required';
        $this->type = $params['type'] ?? '';
        $this->class = $params['class'] ?? '';
        $this->field = $params['field'] ?? 'input';
        $this->rows = $params['rows'] ?? '';
        $this->value = $params['value'] ?? '';
        $this->text = $params['text'] ?? '';
        $this->option = $params['option'] ?? '';

        switch ($this->field)
        {
            case 'input':
                return $this->surround('
                <label for="' .$this->name.'">' . $this->label.'</label><br>
                <'.$this->field . ' name="' . $this->name.'" type="'.$this->type.'" class="form-control ' . $this->class.'" value="'.$this->value.'" placeholder="' . $this->placeholder . '">');
                break;
            case 'textarea':
                return $this->surround('
                <label for="' .$this->name. '">'.$this->label.'</label><br>
                <'.$this->field.' name="' .$this->name. '" type="'.$this->type.'" class="form-control ' . $this->class . '" rows="'.$this->rows.'" value="">'.$this->value.'</'.$this->field.'>');
                break;
            case 'select':
                return $this->surround('
                <label for="' .$this->name. '">'.$this->label.'</label><br>
                <'.$this->field. ' name="' . $this->name . '" class="form-control ' . $this->class . '">
                    <option value="'.$this->value.'">'. $this->text .'</option>
                    </'.$this->field.'>');
                break;
            case 'button':
                return $this->surround('<'.$this->field.' type="'.$this->type.'" name="'.$this->name.'" value="'.$this->value.'" class="btn '.$this->class.'">'.$this->placeholder.'</'.$this->field.'>');
                break;
        }
    }

    /**
     * @return array
     */
    public function set_params()
    {
        return $form_params = [
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
            'text' => $this->values($this->text),
            'option' => $this->values($this->option),
        ];
    }
}