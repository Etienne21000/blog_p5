<?php
namespace App\Model;

use App\Core\AbstractManager;

class PostManager extends AbstractManager
{
    private $db;

    public function __construct()
    {
//        parent::__construct();
        $this->db = $this->dbConnect();
    }

    public function get_all_posts()
    {
        $query = 'SELECT p.*, u.pseudo FROM Post as p 
    LEFT JOIN User as u ON p.user_id = u.id
    ORDER BY p.creation_date';
        $posts =  $this->get_all($query, Post::class);

        return $posts;
    }

    public function get_single_post($id)
    {
        $query = 'SELECT p.*, u.*
        FROM Post as p 
        LEFT JOIN User as u
        ON p.user_id = u.id
        WHERE p.post_id = :id';

        $post = $this->get_single($id, $query, Post::class);

        return $post;
    }

   /* public function all_posts()
    {
        $query = 'SELECT * FROM Post ORDER BY creation_date';

        $this->db->select($query);
    }*/

}
