<?php
namespace App\Model;

class User extends Entity
{
    private $id;
    private $pseudo;
    private $mail;
    private $pass;
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

    public function setPseudo($pseudo)
    {
        $this->pseudo = (string)$pseudo;
    }

    public function setMail($mail)
    {
        $this->mail = (string)$mail;
    }

    public function setPass($pass)
    {
        $this->pass = (string)$pass;
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

    public function pseudo()
    {
        return $this->pseudo;
    }

    public function mail()
    {
        return $this->mail;
    }

    public function pass()
    {
        return $this->pass;
    }

    public function creationDate()
    {
        return $this->creation_date;
    }
}
