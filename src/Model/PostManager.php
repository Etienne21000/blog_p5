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
        $this->select('SELECT p.*, u.pseudo');
        $this->from('FROM Post as p');
        $this->join('LEFT JOIN User as u ON p.user_id = u.id');
        $this->orderBy('ORDER BY p.creation_date asc');

        $posts =  $this->get(Post::class);

        return $posts;
    }
    /*public function get_all_posts()
    {
       $posts = $this->select('p.*')->from('Post');
//        $this->join('LEFT JOIN User as u ON p.user_id = u.id');
//        $this->orderBy('ORDER BY p.creation_date asc');

//        $posts =  $this->execute();

        return $posts;
    }*/

    /**
     * @param $id
     * @return array
     */
    public function get_single_post($id)
    {
        $this->select('SELECT p.*, u.*');
        $this->from('FROM Post as p');
        $this->join('LEFT JOIN User as u
        ON p.user_id = u.id');
        $this->where('WHERE p.post_id = :id');

        $post = $this->get(Post::class, $id);

        return $post;
    }

    /*public function create_post()
    {
        $method = array(
            'title' => $this->method('title()'),
            'content' => $this->method('content()')
        );

        $this->insert('INSERT INTO Post(title, content)');
        $this->values('VALUES(:title, :content)');
        $this->create();

//        var_dump($result);
//        exit();

//        $result->bindValue(':title', $post->title());
//        $result->bindValue(':content', $post->content());

//        $this->db->execute($result);

    }*/

    /**
     * @param Post $post
     */
    public function create_post(Post $post)
    {
        $query = $this->db->prepare('INSERT INTO Post(title, content)
        VALUES(:title, :content)');

        $query->bindValue(':title', $post->title());
        $query->bindValue(':content', $post->content());

        $query->execute();

        $values = '$this->query->bindValue(:title, $post->title());
            $this->query->bindValue(\':content\', $post->content())
            $this->query->bindValue(\':title\', $post->title());';

    }

    /**
     * @return mixed
     */
    public function countPosts()
    {

        $this->count('SELECT COUNT(*)');
        $this->from('FROM Post');

        $countPosts = AbstractManager::countAll();

        return $countPosts;
    }
    /*public function countPosts()
    {

//        $this->count('SELECT COU/st');

        $countPosts = $this->from('Post')->count();
//        AbstractManager::count();

        return $countPosts;
    }*/

}
