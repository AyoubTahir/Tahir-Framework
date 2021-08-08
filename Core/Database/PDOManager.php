<?php

declare(strict_types=1);

namespace Tahir\Core\Database;

use PDOException;
use PDO;

class PDOManager
{

    private $statement;
    private $db;

    public function __construct($db)
    {

        $this->db = $db;

    }

    public function persist(string $sqlQuery, $parameters = []): void
    {
        try
        {
            $this->Query($sqlQuery)->bindValues($parameters)->execute();
        }
        catch (PDOException $e)
        {

           throw new PDOException($e->getMessage());
        }
    }

    
    public function Query(string $sql) : self
    {
        $this->statement = $this->db->open()->prepare($sql);
        
        return $this;
    }


    private function bind(mixed $value): int
    {
        return match ($value)
        {
            is_bool($value) => PDO::PARAM_BOOL,
            intval($value) => PDO::PARAM_INT,
            is_null($value) => PDO::PARAM_NULL,
            default => PDO::PARAM_STR,
        };
    }

    protected function bindValues(array $fields)
    {

        if ( is_array($fields) && count($fields) > 0 )
        {
            foreach ($fields as $key => $value)
            {
                $this->statement->bindValue(':' . $key, $value, $this->bind($value));
            }
        }

        return $this;
    }

    
    public function execute()
    {
        return $this->statement->execute();
    }

    
    public function resultSet() {
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    
    public function single()
    {
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    
    public function rowCount()
    {
        return $this->statement->rowCount();
    }
}