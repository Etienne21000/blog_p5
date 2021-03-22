<?php
namespace App\Model;

use App\Core\AbstractManager;
use \PDO;
use Twig\Error\Error;

class PostManager extends AbstractManager
{
    private $db;

    /**
     * PostManager constructor.
     */
    public function __construct()
    {
        parent::__construct($this->db);
        $this->db = $this->DbConnect();
    }

    /**
     * @param int $where
     * @param int $start
     * @param int $limit
     * @return array
     */
    public function get_all_posts($where, $start =-1, $limit=-1)
    {
        $posts = [];
        /*$sql = 'SELECT p.title, p.status, p.content, p.user_id,
                DATE_FORMAT(p.edition_date, \'%d/%m/%Y à %Hh%i\') AS edition_date,
                DATE_FORMAT(p.creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date, u.*
                FROM Post AS p
                LEFT JOIN User AS u
                ON u.user_id = p.user_id
                WHERE p.status = :status
                ORDER BY creation_date';*/

        $sql = 'SELECT p.*, u.*
                FROM Post AS p
                LEFT JOIN User AS u 
                ON u.user_id = p.user_id
                WHERE p.status = :status
                ORDER BY p.post_id DESC';

        if($start !=-1 && $limit !=-1){
            $sql.= ' LIMIT '. (int)$limit.' OFFSET '.(int)$start;
        }

            $req = $this->db->prepare($sql);

            $req->bindValue(':status', $where, \PDO::PARAM_INT);

            $req->execute();

            while ($data = $req->fetch(\PDO::FETCH_ASSOC)) {
                $post = new Post($data);
                $posts[] = $post;
            }
        return $posts;
    }

    public function count_posts($param)
    {
        return $this->from('Post', 'p')->count($param);
    }

    /**
     * @param $id
     * @return array
     */
    public function get_single_post($id)
    {
        $segment = $this->segmentUri();
        $id = $segment[2];
        $this->select()
            ->from('Post', 'p')
            ->join('User as u', 'u.user_id = p.user_id')
            ->params([':id' => $id])
            ->where('p.post_id = :id');
        $post = $this->resp(Post::class, $id);
        return $post;
    }

    public function create_post(Post $post)
    {
        $sql = 'INSERT INTO Post(title, content, creation_date, status, user_id)
        VALUES(:title, :content, NOW(), :status, :user_id)';
        $req = $this->db->prepare($sql);
        $req->bindValue(':title', $post->title());
        $req->bindValue(':content', $post->content());
        $req->bindValue(':status', $post->status());
        $req->bindValue(':user_id', $post->user_id(), \PDO::PARAM_INT);
        $req->execute();
    }

    public function update_post(Post $post){
        $sql = 'UPDATE Post SET title = :title, content = :content, edition_date = NOW(), status = :status
                WHERE post_id = :post_id';
        $req = $this->db->prepare($sql);
        $req->bindValue(':title', $post->title());
        $req->bindValue(':content', $post->content());
        $req->bindValue(':status', $post->status());
        $req->bindValue(':post_id', $post->post_id(), \PDO::PARAM_INT);
        $req->execute();
    }

    public function drafting(Post $post){
        $sql = 'UPDATE Post SET status = 0
                WHERE post_id = :post_id';
        $req = $this->db->prepare($sql);
        $req->bindValue('post_id', $post->post_id(), \PDO::PARAM_INT);
        $req->execute();
    }

    public function delete($post_id){
        $sql = 'DELETE FROM Post
                WHERE post_id = :post_id';
        $req = $this->db->prepare($sql);
        $req->bindValue(':post_id', $post_id, \PDO::PARAM_INT);
        $req->execute();
    }
}
