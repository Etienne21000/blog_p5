<?php
namespace App\Model;

class Post extends Entity
{
    private $id;
    private $title;
    private $content;
    private $creation_date;

    public function __construct(array $data)
    {
        $this->hydrate = $this->hydrate($data);
    }

    /**************************************
     *************** Setters **************
     **************************************/

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function setTitle($title)
    {
        $this->title = (string)$title;
    }

    public function setContent($content)
    {
        $this->content = (string)$content;
    }

    public function setCreationdate($creation_date)
    {
        $this->creation_date = (string)$creation_date;
    }

    /**************************************
     *************** Getters **************
     **************************************/

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function content()
    {
        return $this->content;
    }

    public function creationDate()
    {
        return $this->creation_date;
    }
}
