<?php
namespace App\Model;
use App\Core\Entity;

class Comment extends Entity
{
    private $id;
    private $title;
    private $content;
    private $user_id;
    private $post_id;
    private $creation_date;
    private $update_date;
    private $status;
    private $parent_id;
    private $pseudo;

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

    public function setUserid($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    public function setPostid($post_id)
    {
        $this->post_id = (int)$post_id;
    }

    public function setCreationdate($creation_date)
    {
        $this->creation_date = (string)$creation_date;
    }

    public function setUpdatedate($update_date)
    {
        $this->update_date = (string)$update_date;
    }

    public function setStatus($status)
    {
        $this->status = (int)$status;
    }

    public function setParentid($parent_id)
    {
        $this->parent_id = (int)$parent_id;
    }

    /**
     * @param $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = (string)$pseudo;
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

    public function userId()
    {
        return $this->user_id;
    }

    public function postId()
    {
        return $this->post_id;
    }

    public function creationDate()
    {
        return $this->creation_date;
    }

    public function updateDate()
    {
        return $this->update_date;
    }

    public function status()
    {
        return $this->status;
    }

    public function parent_id()
    {
        return $this->parent_id;
    }

    /**
     * @return mixed
     */
    public function pseudo()
    {
        return $this->pseudo;
    }
}
