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

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    private function surround($html)
    {

        return "<{$this->p}>{$html}</{$this->p}>";

    }

    private function values($index)
    {
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    public function inputs($title)
    {
        return $this->surround('<input name="title" type="text" class="form-control" aria-describedby="emailHelp" value="" placeholder="' . $this->values($title). '">');
    }

    public function textArea()
    {
        return $this->surround('<textarea name="content" class="form-control" rows="15" placeholder="Commencez à rédiger votre billet..."></textarea>');
    }

    public function submit()
    {
        return $this->surround('<button type="submit" class="btn btn-primary">Créer</button>');
    }

}