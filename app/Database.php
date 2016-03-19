<?php

namespace App;

use \PDO;
use App\Sqlite;


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
     * Store SQL query results
     *
     * @var array
     */
    public $rows;

    /**
     * Store count of SQL query results
     *
     * @var int
     */
    public $rowCount;


    /**
     * Establish database connection
     * Make SQL query results empty
     */
    public function __construct()
    {
        $this->db = Sqlite::getConnection();

        $this->initQuery();
    }

    /**
     * Get SQL query results row count
     *
     * @return int Count of SQL query results
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
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Initialize query result
     * Set $result to empty array
     */
    protected function initQuery()
    {
        $this->rows = [];
    }

    /**
     * Bind data value to parameter
     *
     * @param array $data Data for SQL query
     */
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

    /**
     * Update row of a table
     *
     * @param  string $table Table name
     * @param  array  $data  Data to be updated
     * @param  int    $id    Id of the row
     * @return bool          Update successfully executed or not
     */
    public function update($table, array $data, $id)
    {
        try
        {
            $args = [];
            foreach ($data as $d)
            {
                $args[] = $d['key'] . ' = :' .$d['key'];
            }

            $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $args).
                   ' WHERE id = ' . $id;

            $this->stmt = $this->db->prepare($sql);
            $this->bind($data);
            $this->stmt->execute();

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    /**
     * Query record in table
     *
     * @param  string $table Table name
     * @param  array  $data  Data to be queried
     * @return bool          Query successfully executed or not
     */
    public function query($table, array $data, $limit = null)
    {
        try
        {
            $args = [];
            foreach ($data as $d)
            {
                $args[] = $d['key'] . ' = :' .$d['key'];
            }

            $sql  = 'SELECT * FROM ' . $table . ' WHERE ' .
                    implode(' AND ', $args);
            if (!null)
            {
                $sql .= ' LIMIT ' . $limit;
            }

            $this->stmt = $this->db->prepare($sql);
            $this->bind($data);
            $this->stmt->execute();

            $this->rows     = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->rowCount = count($this->rows);

            return true;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

}
