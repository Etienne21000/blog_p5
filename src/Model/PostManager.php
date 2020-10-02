<?php
namespace App\Model;

use App\Core\AbstractManager;
//use MongoDB\Driver\Query;
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

    public function create_post()
    {


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
