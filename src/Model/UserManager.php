<?php
namespace App\Model;

use App\Core\AbstractManager;
use \PDO;

class UserManager extends AbstractManager
{
    private $db;

    public function __construct()
    {
        parent::__construct($this->db);
        $this->db = $this->dbConnect();
    }

    /**
     * @param User $user
     */
    public function create_user(User $user)
    {
        $sql = 'INSERT INTO User(pseudo, mail, pass, creation_date, role)
        VALUES(:pseudo, :mail, :pass, NOW(), 0)';
        $req = $this->db->prepare($sql);

        $req->bindValue(':pseudo', $user->pseudo());
        $req->bindValue(':mail', $user->mail());
        $req->bindValue(':pass', $user->pass());

        $req->execute();
    }

    public function check_pseudo($pseudo)
    {
        $sql = 'SELECT pseudo, pass, user_role FROM User
        WHERE LOWER(pseudo) = :pseudo';
        $req = $this->db->prepare($sql);

        $req->bindValue(':pseudo', strtolower($pseudo));

        $req->execute();

        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    public function check_mail($mail)
    {
        $req = $this->db->prepare('SELECT mail FROM User
        WHERE mail = :mail');

        $req->bindValue(':mail', $mail);

        $req->execute();

        return $req->fetch(\PDO::FETCH_ASSOC);
    }

//    public function get_user_id()

    public function delete_user(){

    }

    public function get_user(){

    }
}