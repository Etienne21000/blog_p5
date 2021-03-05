<?php
namespace App\Model;

use App\Core\AbstractManager;
use \PDO;

class CommentManager extends AbstractManager
{
    private $db;

    public function __construct()
    {
        parent::__construct($this->db);
        $this->db = $this->DbConnect();
    }

    /**
     * @param Comment $comment
     */
    public function add_comment(Comment $comment){
        $sql = 'INSERT INTO Comment(user_id, title, content, post_id, status, creation_date)
                VALUES(:user_id, :title, :content, :post_id, 0, NOW())';

        $req = $this->db->prepare($sql);

        $req->bindValue(':user_id', $comment->userId(), \PDO::PARAM_INT);
        $req->bindValue(':title', $comment->title(), \PDO::PARAM_STR);
        $req->bindValue(':content', $comment->content(), \PDO::PARAM_STR);
        $req->bindValue(':post_id', $comment->postId(), \PDO::PARAM_INT);

        $req->execute();
    }

    /**
     * @param $post_id
     * @return array
     */
    public function get_comments_by_post($post_id){

        $Comments = [];

        $sql = 'SELECT c.id, c.title, c.post_id, c.content, u.*,
                DATE_FORMAT(c.creation_date, \'%d/%m/%Y à %Hh%i\')
                FROM Comment AS c
                LEFT JOIN User AS u
                ON u.user_id = c.user_id
                WHERE c.post_id = :post_id
                AND c.status = 1
                ORDER BY c.creation_date DESC';

        $req = $this->db->prepare($sql);

        $req->bindValue(':post_id', $post_id, \PDO::PARAM_INT);

        $req->execute();

        while ($data = $req->fetch(\PDO::FETCH_ASSOC)){

            $Comment = new Comment($data);

            $Comments[] = $Comment;
        }
        return $Comments;
    }

}