<?php

namespace App;

use App\Sqllite;
use \PDO;
use \PDOException;
use \RuntimeException;

class Database
{
    /**
     * Database connection
     *
     * @var PDO object
     */
    private $_db;

    /**
     * Bind parameter
     *
     * @var PDO object
     */
    private $_stmt;

    /**
     * Number of rows of last query
     *
     * @var int
     */
    public $rowCount;

    /**
     * Query result
     *
     * @var array
     */
    public $result;

    /**
     * Create Sqlite connection
     */
    public function __construct()
    {
        $this->_db = Sqllite::getConnection();
    }

    /**
     * Initialize query result to null
     */
    private function _initQuery()
    {
        $this->result = array();
    }

    /**
     * Bind parameter
     *
     * @param  array  $data Data to be inserted to table
     */
    private function _bind(array $data)
    {
        foreach($data as $d)
        {
            if ($d['type'] == 'INT')
            {
                $this->_stmt->bindValue(':'.$d['key'],
                                        $d['value'],
                                        PDO::PARAM_INT);
            }
            else if ($d['type'] == 'STR')
            {
                $this->_stmt->bindValue(':'.$d['key'],
                                        $d['value'],
                                        PDO::PARAM_STR);
            }
        }
    }

    /**
     * Insert data to table
     *
     * @param  string $table Table name
     * @param  array  $data  Data to be inserted in table
     *
     * @return bool   Success or failure to set value
     */
    public function setValueOf($table, array $data)
    {
        $this->_initQuery();

        $keys = array();
        foreach ($data as $d)
        {
            $keys[] = $d['key'];
        }

        try
        {
            $sql  = 'INSERT INTO '.$table.'('.implode(', ', $keys).') '.
                    'VALUES (:'.implode(', :', $keys).')';

            $this->_stmt = $this->_db->prepare($sql);
            $this->_bind();
            $this->_stmt->execute();

            return true;
        }

        catch (PDOException $e)
        {
            throw new RuntimeException($e->getMessage(), 101);

            return false;
        }
    }

    /**
     * Get value of filed from a table
     *
     * @param  string $table Name of table
     * @param  array  $data  Query data
     *
     * @return bool          Success or failure to get value
     */
    public function getValueOf($table, array $data)
    {
        $this->_initQuery();

        try
        {
            $sql  = 'SELECT * FROM '.$table.' WHERE '.
                    $data['key'].' = :'.$data['key'].' LIMIT 1';

            $this->_stmt = $this->_db->prepare($sql);
            $this->_bind(array($data));
            $this->_stmt->execute();
            $this->result   = $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->rowCount = count($this->result);
            if ($this->rowCount > 0)
            {
                $this->result = array_shift($this->result);
            }

            return true;
        }

        catch (PDOException $e)
        {
            throw new RuntimeException($e->getMessage(), 102);

            return false;
        }
    }

}
