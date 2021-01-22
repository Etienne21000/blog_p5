<?php
namespace App\Model;
use App\Core\Entity;

class User extends Entity
{
    private $user_id;
    private $pseudo;
    private $mail;
    private $pass;
    private $role;
    private $creation_date;

    public function __construct(array $data)
    {
        $this->hydrate = $this->hydrate($data);
    }

    /**************************************
     *************** Setters **************
     *************************************
     * @param $user_id
     */

    public function setId($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    /**
     * @param $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = (string)$pseudo;
    }

    /**
     * @param $mail
     */
    public function setMail($mail)
    {
        $this->mail = (string)$mail;
    }

    /**
     * @param $pass
     */
    public function setPass($pass)
    {
        $this->pass = (string)$pass;
    }

    /**
     * @param $role
     */
    public function setType($role)
    {
        $this->role = (int)$role;
    }

    /**
     * @param $creation_date
     */
    public function setCreationdate($creation_date)
    {
        $this->creation_date = (string)$creation_date;
    }

    /**************************************
     *************** Getters **************
     **************************************/

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
    public function pseudo()
    {
        return $this->pseudo;
    }

    /**
     * @return mixed
     */
    public function mail()
    {
        return $this->mail;
    }

    /**
     * @return mixed
     */
    public function pass()
    {
        return $this->pass;
    }

    /**
     * @return mixed
     */
    public function role()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function creationDate()
    {
        return $this->creation_date;
    }
}
