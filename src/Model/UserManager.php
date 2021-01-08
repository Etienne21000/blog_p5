<?php
namespace App\Model;

use App\Core\AbstractManager;
use \PDO;

class UserManager extends AbstractManager
{
    private $db;

    public function __construct(){
    parent::__construct($this->db);
    $this->db = $this->dbConnect();
}

    public function addUser(User $user)
    {
        $sql = "INSERT INTO User(pseudo, mail, pass, creation_date, role, img_id)
        VALUES(:pseudo, :mail, :pass, NOW(), 0)";
        $req = $this->db->prepare($sql);

        $req->bindValue(':identifiant', $user->identifiant());
        $req->bindValue(':mail', $user->mail());
        $req->bindValue(':pass', $user->passWord());

        $req->execute();
    }

    public function get_user(){

    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}