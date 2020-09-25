<?php
namespace App\Model;

use App\Core\AbstractManager;

class PostManager extends AbstractManager
{
    private $db;

    /**
     * PostManager constructor.
     */
    public function __construct()
    {
        parent::__construct($this->db);
    }

    /**
     * @return array
     */
    public function get_all_posts()
    {
        $this->select('p.*, u.pseudo');
        $this->from('Post as p');
        $this->join('LEFT JOIN User as u ON p.user_id = u.id');
        $this->orderBy('p.creation_date asc');

        $this->get();

        $posts = $this->resp(Post::class);

        return $posts;
    }

    /**
     * @param $id
     * @return array
     */
    public function get_single_post($id)
    {
        $this->select('p.*, u.*');
        $this->from('Post as p');
        $this->join('LEFT JOIN User as u
        ON p.user_id = u.id');
        $this->where('p.post_id = :id');

        $this->get();

        $post = $this->resp(Post::class, $id);

        return $post;
    }

    public function create_post()
    {
        $method = array(
            'title' => $this->method('title()'),
            'content' => $this->method('content()')
        );

        $this->insert('Post(title, content)');
        $this->values(':title, :content');
        $this->create();

//        var_dump($result);
//        exit();

//        $result->bindValue(':title', $post->title());
//        $result->bindValue(':content', $post->content());

//        $this->db->execute($result);

    }


    /*public function create_post(Post $post)
    {
        $query = $this->db->prepare('INSERT INTO Post(title, content)
        VALUES(:title, :content)');

        $query->bindValue(':title', $post->title());
        $query->bindValue(':content', $post->content());

        $query->execute();

        $values = '$this->query->bindValue(:title, $post->title());
            $this->query->bindValue(\':content\', $post->content())
            $this->query->bindValue(\':title\', $post->title());';

    }*/

    /**
     * @return mixed
     */
    public function countPosts()
    {

        $this->count('*');
        $this->from('Post');
//        $this->where('post_id = 1');

        $countPosts = $this->countAll();

        return $countPosts;
    }
}
