<?php
namespace App\Model;

use App\Core\AbstractManager;
use \PDO;

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
     * @return array
     */
    public function get_all_posts()
    {
        $this->select('p.*', 'u.*')
            ->from('Post', 'p')
            ->join('User as u', 'u.id = p.user_id')
            ->order('p.creation_date DESC')
            ->limit('0', '3');

        $posts = $this->resp(Post::class);

        return $posts;
    }

    public function testCount()
    {
        return $this->from('Post', 'p')->count();
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
            ->join('User as u', 'u.id = p.user_id')
            ->params([':id' => $id])
            ->where('p.post_id = :id');

        $post = $this->resp(Post::class, $id);

        return $post;
    }

    public function get_all()
    {
        $this->query_string('SELECT * FROM Posts ');
        $posts = $this->resp(Post::class);
        return $posts;
    }

    public function create_post(Post $post)
    {
        $sql = 'INSERT INTO post(title, content, creation_date)
        VALUES(:title, :content, NOW())';
        $req = $this->db->prepare($sql);

        $req->bindValue(':title', $post->title());
        $req->bindValue(':content', $post->content());

        $req->execute();

    }
}
