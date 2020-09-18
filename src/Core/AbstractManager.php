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
    private $class;
    private $method;

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

    /*
     *
     * Method to get all && single entities
     * -> get the uri segment & check if $id param is defined
     * -> get the queries() method
     * -> check if params are defined with switch
     * -> check if param $where is defined to create the proper query
     *
     */
    /**
     * @param $class_name
     * @param int $id
     * @return array
     */
    public function get($class_name, $id = -1)
    {

        $segments = $this->segmentUri();

        if (isset($id) && $id != -1) {
            $id = $segments[2];
        } else {
            $id = NULL;
        }

        $select = $this->select;
        $from = $this->from;
        $join = $this->join;
        $order = $this->order;
        $where = $this->where;
        $count = $this->count;

        /*switch ($this->query) {
            case isset($select);
                echo $select;
                break;

            case isset($from);
                echo $from;
                break;

            case isset($join);
                echo $join;
                break;

            case isset($order);
                echo $order;
                break;

            case isset($where);
                echo $where;
                break;

            case isset($count);
                echo $count;
                break;
        }*/

        $query = $select . ' ' . $from . ' ' . $join . ' ' . $where . ' ' . $order;

        $this->query = $this->db->prepare($query);

        if (isset($where)) {

            $this->query->bindValue(':id', $id, \PDO::PARAM_INT);

            $this->query->execute();

            $data = $this->query->fetch(\PDO::FETCH_ASSOC);

            $class = $class_name;
            $params = new $class($data);
        } elseif (!isset($where)) {
            $params = [];

            $this->query->execute();

            while ($data = $this->query->fetch(\PDO::FETCH_ASSOC)) {
                $class = $class_name;
                $class = new $class($data);

                $params[] = $class;
            }
        }

        return $params;
    }

    /*
     *
     * Method to count all elements
     * -> get params $from & $count to define which elements we need to count
     * -> get the queries() method
     * -> concatenate the params in $query var
     * -> get the result
     *
     */
    /**
     * @return mixed
     */
    public function countAll()
    {
        $from = $this->from;
        $count = $this->count;

        $query = $count . ' ' . $from;

        $result = $this->db->query($query)->fetchColumn();

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

    /**
     * @param $class
     * @return mixed
     */
    public function class_name($class)
    {
        $this->class = (string)$class;
        return $class;
    }

    /**
     * @param $method
     * @return mixed
     */
    public function method($method)
    {
        $this->method = (string)$method;
        return $method;
    }

    /**
     * @param $insert
     * @return mixed
     */
    public function insert($insert)
    {
        $this->insert = $insert;
//        $insert = 'INSERT '.$insert;
        return $insert;
    }

    /**
     * @param $values
     * @return mixed
     */
    public function values($values)
    {
        $this->values = $values;
        return $values;
    }

    /**
     * @param $count
     * @return mixed
     */
    public function count($count)
    {
        $this->count = (string)$count;
        return $count;
    }

    /**
     * @param $select
     * @return mixed
     */
    public function select($select)
    {
        $this->select = (string)$select;
        return $select;
    }

    /**
     * @param $from
     * @return mixed
     */
    public function from($from)
    {
        $this->from = (string)$from;
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
        $this->order = (string)$order;
        return (string)$order;
    }

    /**
     * @param $where
     * @return mixed
     */
    public function where($where)
    {
        $this->where = (string)$where;
        return $where;
    }
}

