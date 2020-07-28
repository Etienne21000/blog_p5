<?php
namespace App\Model;

class Image extends Entity
{
    private $id;
    private $title;
    private $filename;
    private $description;
    private $post_id;
    private $user_id;
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

    public function setFilename($fileName)
    {
            $this->filename = (string)$fileName;
    }

    public function setDescription($description)
    {
            $this->description = (string)$description;
    }

    public function setPostId($post_id)
    {
        $this->post_id = (int)$post_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    public function setCreationDate($creation_date)
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

    public function filename()
    {
        return $this->filename;
    }

    public function description()
    {
        return $this->description;
    }

    public function post_id()
    {
        return $this->post_id;
    }

    public function user_id()
    {
        return $this->user_id;
    }

    public function creation_date()
    {
        return $this->creation_date;
    }
}
