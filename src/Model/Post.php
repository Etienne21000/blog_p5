<?php
namespace App\Model;
use App\Core\Entity;

class Post extends Entity
{
    /**
     * @var $post_id
     */
    private $post_id;

    /**
     * @var $title
     */
    private $title;
    /**
     * @var $content
     */
    private $content;
    /**
     * @var $creation_date
     */
    private $creation_date;
    /**
     * @var $edition_date
     */
    private $edition_date;
    /**
     * @var $status
     */
    private $status;
    /**
     * @var $user_id
     */
    private $user_id;
    /**
     * @var $img_id
     */
    private $img_id;

    private $status_text;
    private $pseudo;

    /**
     * Post constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**************************************
     *************** Setters **************
     **************************************/

    /**
     * @param $post_id
     */
    public function setPostid($post_id)
    {
        $this->post_id = (int)$post_id;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = (string)$title;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = (string)$content;
    }

    /**
     * @param $creation_date
     */
    public function setCreationdate($creation_date)
    {
        $this->creation_date = (string)$creation_date;
    }

    /**
     * @param $edition_date
     */
    public function setEditiondate($edition_date)
    {
        $this->edition_date = (string)$edition_date;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param $user_id
     */
    public function setUserid($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    /**
     * @param $img_id
     */
    public function setImgId($img_id)
    {
        $this->img_id = (int)$img_id;
    }

    /**
     * @param $status_text
     */
    /*public function setStatustext($status_text)
    {
        $this->status_text = (string)$status_text;
    }*/

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

    /**
     * @return mixed
     */
    public function post_id()
    {
        return $this->post_id;
    }

    /**
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function creationDate()
    {
        return $this->creation_date;
    }

    /**
     * @return mixed
     */
    public function editionDate()
    {
        return $this->edition_date;
    }

    /**
     * @return mixed
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function user_id()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function img_id()
    {
        return $this->img_id;
    }

    /**
     * @return string
     */
    /*public function status_text()
    {
        if($this->status == false)
        {
            return $this->status_text = 'Brouillon';
        }
        else{

            return $this->status_text = 'Publié';
        }
    }*/

    /**
     * @return mixed
     */
    public function pseudo()
    {
        return $this->pseudo;
    }
}
