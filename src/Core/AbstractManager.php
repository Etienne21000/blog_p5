<?php
namespace App\Core;

use PDO;

abstract class AbstractManager
{

    private $db;
    private $query;
    private $table;
    private $column;
    private $where;
    private $from;

    /*public function __construct()
    {
        $this->db = $this->DbConnect();
    }*/

    public function DbConnect()
    {
        try
        {
            $this->db = new \PDO('mysql:host=localhost;dbname=blog_etienne', 'root', 'root',
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

            return $this->db;
        }

        catch (\Exception $e)
        {
            die('Erreur : ' .$e->getMessage());
        }
    }

    public function get_all($statement, $class_name)
    {
        $this->db = $this->DbConnect();
        $params = [];
        $this->query = $this->db->prepare((string)$statement);

        $this->query->execute();

        while ($data = $this->query->fetch(\PDO::FETCH_ASSOC))
        {
            $class = $class_name;
            $class = new $class($data);

            $params[] = $class;
        }

        return $params;
    }

    public function get_single($id, $statement, $class_name)
    {
        $this->db = $this->DbConnect();

        $this->query = $this->db->prepare((string)$statement);

        $this->query->bindValue(':id', $id, \PDO::PARAM_INT);

        $this->query->execute();

        $data = $this->query->fetch(\PDO::FETCH_ASSOC);

        $class = $class_name;
        $param = new $class($data);

        return $param;
    }

    public function select($query)
    {
        $this->query = (string)$query;

        return $query;
    }

    /*public function get()
    {
        $this->query->execute();
    }*/

    public function from($table)
    {

    }

    public function join()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function  where()
    {

    }



    public function get()
    {

    }

    public function result()
    {

    }

    public function orderBy()
    {

    }
}
