<?php
namespace App\Model;

use App\Model\Post;
use App\Model\Comment;
use App\Model\User;
use App\Core\Router;

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
    private $method;
    private $title;
    private $type;
    private $value;

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * create the HTML form
     * get params :
     * -> method
     * -> action
     * -> onclick
     * -> id
     * -> class
     * @param array $val
     */
    public function form($val = array())
    {

    }

    private function surround($html)
    {

        return "<{$this->p}>{$html}</{$this->p}>";

    }

    private function values($index)
    {
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    public function inputs($params = [])
    {
        $params[] = $this->set_params();

        return $this->surround('
        <label for="'
            .(isset($params['name']) ? $params['name'] : 'name').
            '">'
            .(isset($params['label']) ? $params['label'] : 'label').
            '</label><br>
        <input name="'
            .(isset($params['name']) ? $params['name'] : 'default').
            '" type="'
            .(isset($params['type']) ? $params['type'] : 'default').
            '" class="form-control '
            .(isset($params['class']) ? $params['class'] : '').
            '" value="" placeholder="'
            .(isset($params['placeholder']) ? $params['placeholder'] : 'Titre').
            '">');
    }

    public function textArea($params = [])
    {
        $params[] = $this->set_params();

        return $this->surround('
        <label for="'.$params['name'].'">'.$params['label'].'</label><br>
        <textarea name="'.$params['name'].'" class="form-control" rows="15" placeholder="'.$params['placeholder'].'"></textarea>');
    }

    public function submit()
    {
        return $this->surround('<button type="submit" class="btn btn-primary">Créer</button>');
    }

    /**
     * @return array
     */
    public function set_params()
    {
        $form_params = [
            'label' => $this->values($this->label),
            'for' => $this->values($this->for),
            'name' => $this->values($this->name),
            'placeholder' => $this->values($this->placeholder),
            'class' => $this->values($this->class),
            'id' => $this->values($this->id),
            'title' => $this->values($this->title),
            'type' => $this->values($this->type),
            'value' => $this->values($this->value)
//            'method' => $this->method,
        ];

        return $form_params;
    }

}