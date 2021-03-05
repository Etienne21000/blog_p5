<?php


namespace App\Core;

use \PDO;
use App\Model\Post;
use PDOStatement;

abstract class AbstractManager
{
    private $db;
    private $query;
    private $select;
    private $order = [];
    private $join;
    private $where = [];
    private $from;
    private $update;
    private $insert;
    private $params;
    private $limit;

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
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $this->db;
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * @return array
     * passer dans l'abstract controller
     */
    public function segmentUri()
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
     * @param $class_name
     * @param $parameter
     * @return array
     */
    public function resp($class_name, $parameter=-1)
    {
        $params = [];

        $query = $this->__toString();

        if ($this->where)
        {
            $stm = $this->db->prepare($query);

                $stm->bindValue(':id', $parameter, \PDO::PARAM_INT);

                $stm->execute();

            $data = $stm->fetch(\PDO::FETCH_ASSOC);

            $class = $class_name;
            $params = new $class($data);

        }
        elseif(!$this->where)
        {
            $id = NULL;

            $query = $this->execute_query();

            while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
                $class = $class_name;
                $class = new $class($data);

                $params[] = $class;
            }
        }
        return $params;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $parts = ['SELECT'];
        if($this->select)
        {
            $parts[] = join(', ', $this->select);
        }
        else
        {
            $parts[] = '*';
        }

        $parts[] = 'FROM';
        $parts[] = $this->fromArray();

        if(!empty($this->join))
        {
            foreach ($this->join as $key => $value)
            {
                foreach ($value as [$table, $cond])
                {
                    $parts[] = strtoupper($key) . " JOIN $table ON $cond";
                }
            }
        }

        if(!empty($this->order))
        {
            $parts[] = 'ORDER BY';

                $parts[] = join(', ', $this->order);
        }

        if($this->limit)
        {
            $parts[] = 'LIMIT ' . $this->limit;
        }

        if(!empty($this->where))
        {
            $parts[] = 'WHERE';
            $parts[] = '(' .join(') AND (', $this->where).')';
        }

        return join(' ', $parts);

    }

    /**
     * @return string
     */
    private function fromArray(): string
    {
        $from = [];

        foreach ($this->from as $key => $value)
        {
            if(is_string($key))
            {
                $from[] = "$value AS $key";
            }
            else
            {
                $from[] = $value;
            }
        }
        return join(', ', $from);
    }

    /**
     * @return bool|false|PDOStatement
     */
    private function execute_query()
    {
        $query = $this->__toString();

        if($this->params)
        {
            $state = $this->db->prepare($query);
            $state->execute($this->params);
            return $state;
        }

        else
        {
            return $this->db->query($query);
        }
    }

    public function query_string(string $query): self
    {
        $this->query = $query;
        return $this;
    }

    public function params(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param $insert
     * @return mixed
     */
    public function insert($insert): self
    {
        $this->insert = $insert;
        return $this;
    }

    public function update($update): self
    {
        $this->update = $update;
        return $this;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $this->select("COUNT(*)");
        return $this->execute_query()->fetchColumn();
    }

//    public function query_string(): self
//    {
//        $this->query()
//    }

    /**
     * @param string ...$fields
     * @return $this
     */
    public function select(string ...$fields): self
    {
        $this->select = $fields;
        return $this;
    }

    /**
     * @param int $lenght
     * @param int $offset
     * @return $this
     */
    public function limit(int $lenght, int $offset = 0): self
    {
        $this->limit = "$lenght, $offset";
        return $this;
    }

    /**
     * @param string $order
     * @return AbstractManager
     */
    public function order(string $order): self
    {
        $this->order[] = $order;
        return $this;
    }

    /**
     * @param string $table
     * @param string|null $alias
     * @return mixed
     */
    public function from(string $table, ?string $alias = null)
    {
        if($alias)
        {
            $this->from[$alias] = $table;
        }
        else
        {
            $this->from[] = $table;
        }
        return $this;
    }

    /**
     * @param $cond
     * @return mixed
     */
    public function where(string ...$cond): self
    {
        $this->where = $cond;
        return $this;
    }

    /**
     * @param string $table
     * @param string $cond
     * @param string $type
     * @return mixed
     */
    public function join(string $table, string $cond, string $type = "left"): self
    {
        $this->join[$type][] = [$table, $cond];
        return $this;
    }
}

