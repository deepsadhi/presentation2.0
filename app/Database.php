<?php

namespace App;

use App\Sqllite;

class DB
{
    private $_db;
    public $lastInsertId;
    public $error = false;

    public function __construct()
    {
        $this->_db = Sqllite::getConnection();
    }

    public function insert($table, array $data)
    {
        $keys = array();
        foreach ($data as $key => $value)
        {
            $keys[] = $key;
        }

        try {
            $sql  = 'INSERT INTO '.$table.'('.implode(', ', $keys).') ';
            $sql .= 'VALUES (:'.implode(', :', $keys).')';

            $stmt = $this->_db->prepare($sql);
            foreach($data as $key => $value)
            {
                if ($key == 'r_id')
                {
                    $stmt->bindValue(':'.$key, $value, PDO::PARAM_INT);
                }
                else
                {
                    $stmt->bindValue(':'.$key, $value, PDO::PARAM_STR);
                }
            }
            $stmt->execute();
            $this->lastInsertId = $this->_db->lastInsertId();

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function query($sql)
    {
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();

            $result = array();
            $result['categories'] = $stmt->fetchAll(PDO::FETCH_COLUMN);

            $stmt->execute();
            $result['rows'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result['error'] = false;

            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            $result['error'] = true;
            return $result;
        }
    }

    public function findByCId($c_id)
    {
        try
        {
            $sql = 'SELECT * FROM email WHERE c_id=?';
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(1, $c_id, PDO::PARAM_INT);
            $stmt->execute();
            return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e)
        {
            error_log($e->getMessage());
            return false;
        }
    }

}
