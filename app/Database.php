<?php

namespace App;

use App\Sqlite;
use \PDO;
use \PDOException;
use \Exception;

class Database
{
    /**
     * Store database connection
     *
     * @var PDO object
     */
    protected $db;

    /**
     * Store SQL query
     *
     * @var PDO object
     */
    protected $stmt;

    /**
     * Store SQL query result
     *
     * @var array
     */
    public $result;

    /**
     * Store count of SQL query
     *
     * @var [type]
     */
    public $rowCount;

    /**
     * Initialize database
     */
    public function __construct()
    {
        $this->db = Sqlite::getConnection();

        $this->initQuery();
    }


    /**
     * Get SQL query result row count
     *
     * @return int Count of SQL query result
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }


    /**
     * Get SQL query result
     *
     * @return array SQL query result
     */
    public function getResult()
    {
        return $this->result;
    }


    /**
     * Initialize query
     * Set $result to empty array
     *
     * @return [type] [descriptio
     */
    protected function initQuery()
    {
        $this->result = [];
    }


    protected function bind(array $data)
    {
        foreach($data as $d)
        {
            if ($d['type'] == 'INT')
            {
                $this->stmt->bindValue(':'.$d['key'],
                                        $d['value'],
                                        PDO::PARAM_INT);
            }
            else if ($d['type'] == 'STR')
            {
                $this->stmt->bindValue(':'.$d['key'],
                                        $d['value'],
                                        PDO::PARAM_STR);
            }
        }
    }


    public function update($table, array $data, $id)
    {
        try
        {
            $args = [];
            foreach ($data as $d)
            {
                $args[] = $d['key']. ' = :' .$d['key'];
            }

            $sql = 'UPDATE '.$table.' SET '. implode(', ', $args).
                   ' WHERE id = `'. $id .'`';

            $this->stmt = $this->db->prepare($sql);
            $this->bind($data);
            $this->stmt->execute();

            return true;
        }
        catch (PDOException $e)
        {
            // throw new Exception($e->getMessage());
            return false;
        }
    }


    public function query($table, array $data)
    {
        try
        {
            $args = [];
            foreach ($data as $d)
            {
                $args[] = $d['key']. ' = :' .$d['key'];
            }

            $sql  = 'SELECT * FROM '.$table . ' WHERE ' .
                    implode(' AND ', $args) . ' LIMIT 1';

            $this->stmt = $this->db->prepare($sql);
            $this->bind($data);
            $this->stmt->execute();

            $this->result   = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->rowCount = count($this->result);

            if ($this->rowCount > 0)
            {
                $this->result = array_shift($this->result);
            }

            return true;
        }
        catch (PDOException $e)
        {
            // throw new Exception($e->getMessage());
            return false;
        }
    }

}
