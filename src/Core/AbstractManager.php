<?php


namespace App\Core;

use \PDO;
use App\Model\Post;

abstract class AbstractManager
{
    private $db;
    private $query;
    private $select;
    private $order;
    private $join;
    private $where;
    private $from;
    private $count;
    private $values;
    private $insert;

    /**
     * AbstractManager constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->db = $this->DbConnect();
    }

    /**
     * @return mixed|PDO|string
     */
    public function DbConnect()
    {
        try {
            $this->db = new \PDO('mysql:host=localhost;dbname=blog_etienne', 'root', 'root',
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

            return $this->db;
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * @return array
     */
    private function segmentUri()
    {
        $segments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        return $segments;
    }

    public function total_uri()
    {
        $segments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        return count($segments);
    }

    /**
     * @return array|bool|\PDOStatement
     */
    public function get()
    {
        $resp = [];

        if (isset($this->where))
        {

            $query = $this->select . ' ' . $this->from . ' ' . $this->join . ' ' . $this->where . ' ' . $this->order;

            $resp = $this->query = $this->db->prepare($query);

        }
        elseif (!isset($this->where))
        {

            $query = $this->select . ' ' . $this->from . ' ' . $this->join . ' ' . $this->order;

            $resp = $this->query = $this->db->prepare($query);

        }

        return $resp;
    }

    /**
     * @param $class_name
     * @param int $id
     * @return array
     */
    public function resp($class_name, $id =-1)
    {
        $params = [];

        $query = $this->get();
        $segments = $this->segmentUri();

        if (isset($this->where))
        {
            $id = $segments[2];

            $query->bindValue(':id', $id, \PDO::PARAM_INT);

            $query->execute();

            $data = $query->fetch(\PDO::FETCH_ASSOC);

            $class = $class_name;
            $params = new $class($data);

        }
        elseif(!isset($this->where))
        {
            $id = NULL;

            $query->execute();

            while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
                $class = $class_name;
                $class = new $class($data);

                $params[] = $class;
            }
        }

        return $params;
    }

    /**
     * @return mixed
     * -> get params $from & $count to define which elements we need to count
     * -> get the queries() method
     * -> concatenate the params in $query var
     * -> get the result
     */
    public function countAll()
    {
        if(isset($this->count) && !empty($this->where))
        {
            $query = $this->count . ' ' . $this->from;
            $result = $this->db->query($query)->fetchColumn();
        }
        else
        {
            $query = $this->count . ' ' . $this->from . ' ' . $this->where;
            $result = $this->db->query($query)->fetchColumn();
        }

        return $result;
    }

    /**
     *
     */
    public function create()
    {
        $insert = $this->insert;
        $values = $this->values;

        $query = $insert . ' ' . $values;
        $this->query = $this->db->prepare($query);
//            $this->query->bindValue();
        $this->query->execute();


//        $query = $insert. ' ' . $values;


        /*foreach ($values as $data)
        {
            foreach ($method as $datamethod)
            {
                $this->query->bindValue($data, $datamethod);
            }
        }

        $this->query->execute();*/
    }


    /*public function class_name($class)
    {
        $this->class = (string)$class;
        return $class;
    }*/


    /*public function method($method)
    {
        $this->method = (string)$method;
        return $method;
    }*/

    /**
     * @param $insert
     * @return mixed
     */
    public function insert($insert)
    {
        $this->insert = 'INSERT INTO'.(string)$insert;
        return $insert;
    }

    /**
     * @param $values
     * @return mixed
     */
    public function values(string ...$values): self
    {
        $this->values = 'VALUES('.(string)$values.')';
        return $this;
    }

    /**
     * @param $count
     * @return $this
     */
    public function count($count): self
    {
        $this->count = 'SELECT COUNT('.(string)$count.')';
        return $this;
    }

    /**
     * @param $select
     * @return mixed
     */
    public function select($select): self
    {
        $this->select = 'SELECT '.(string)$select;
        return $this;
    }

    /**
     * @param $from
     * @return mixed
     */
    public function from($from)
    {
        $this->from = 'FROM '.(string)$from;
        return $from;
    }

    /**
     * @param $join
     * @return mixed
     */
    public function join($join)
    {
        $this->join = (string)$join;
        return $join;
    }

    /**
     * @param $order
     * @return string
     */
    public function orderBy($order)
    {
        $this->order = 'ORDER BY '.(string)$order;
        return (string)$order;
    }

    /**
     * @param $where
     * @return mixed
     */
    public function where($where): self
    {
        $this->where = 'WHERE '.(string)$where;
        return $this;
    }
}

