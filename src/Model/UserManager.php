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

    /**
     * @param $pseudo
     * @return mixed
     */
    public function check_pseudo($pseudo)
    {
        $sql = 'SELECT user_id, pseudo, pass, role FROM User
        WHERE LOWER(pseudo) = :pseudo';
        $req = $this->db->prepare($sql);

        $req->bindValue(':pseudo', strtolower($pseudo));

        $req->execute();

        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $mail
     * @return mixed
     */
    public function check_mail($mail)
    {
        $req = $this->db->prepare('SELECT mail FROM User
        WHERE mail = :mail');

        $req->bindValue(':mail', $mail);

        $req->execute();

        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array
     */
    public function get_single_user($id){
        //$segment = $this->segmentUri();
        //$id = $segment[2];
        $this->select()
            ->from('User')
            ->params([':id' => $id])
            ->where('user_id = :id');

        $user = $this->resp(User::class, $id);
        return $user;
    }

    /**
     * @param $user_id
     */
    public function delete_user($user_id){
        $sql = 'DELETE FROM User
                WHERE user_id = :user_id';
        $req = $this->db->prepare($sql);
        $req->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $req->execute();
    }
}