<?php
namespace App\Model;
use App\Core\Entity;

class Post extends Entity
{
    private $post_id;
    private $title;
    private $content;
    private $creation_date;
    private $edition_date;
    private $status;
    private $user_id;
    private $img_id;
    private $status_text;
    private $pseudo;

    public function __construct(array $data)
    {
        $this->hydrate = $this->hydrate($data);
    }

    /**************************************
     *************** Setters **************
     **************************************/

    public function setPostid($post_id)
    {
        $this->post_id = (int)$post_id;
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

    public function setEditiondate($edition_date)
    {
        $this->edition_date = (string)$edition_date;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setUserid($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    public function setImgId($img_id)
    {
        $this->img_id = (int)$img_id;
    }

    public function setStatustext($status_text)
    {
        $this->status_text = (string)$status_text;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = (string)$pseudo;
    }


    /**************************************
     *************** Getters **************
     **************************************/

    public function post_id()
    {
        return $this->post_id;
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

    public function editionDate()
    {
        return $this->edition_date;
    }

    public function status()
    {
        return $this->status;
    }

    public function user_id()
    {
        return $this->user_id;
    }

    public function img_id()
    {
        return $this->img_id;
    }

    public function status_text()
    {
        if($this->status == false)
        {
            return $this->status_text = 'Brouillon';
        }
        else{

            return $this->status_text = 'Publié';
        }
    }

    public function pseudo()
    {
        return $this->pseudo;
    }
}
