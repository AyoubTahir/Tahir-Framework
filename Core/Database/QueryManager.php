<?php

declare(strict_types=1);

namespace Tahir\Core\Database;

class QueryManager
{
    private string $table;

    public function __construct($table)
    {
        $this->table = $table;
    }


    public function selectQuery(string $selectors = '*'): string
    {
        $this->sqlQuery = "SELECT {$selectors} FROM {$this->table}";

        return $this->sqlQuery;
    }

    public function insertQuery($fields): string
    {
        if (is_array($fields) && count($fields) > 0)
        {
            $index = array_keys($fields);

            $params =  implode(', ', $index);
            $values  =  ":" . implode(', :', $index);

            $this->sqlQuery = "INSERT INTO {$this->table} ({$params}) VALUES({$values})";
            
            return $this->sqlQuery;
        }
    }

    public function updateQuery($fields): string
    {
        if (is_array($fields) && count($fields) > 0)
        {
            $values = '';

            foreach (array_keys($fields) as $field)
            {
                if ($field !== 'id')
                {
                    $values .= $field . " = :" . $field . ", ";
                }
            }

            $values = substr_replace($values, '', -2);

            $this->sqlQuery = "UPDATE {$this->table} SET {$values}";

            return $this->sqlQuery;
        }
    }

    public function deleteQuery(): string
    {
        $this->sqlQuery = "DELETE FROM {$this->table}";

        return $this->sqlQuery;
    }


    public function hasConditions($Param,$operator,$with = " WHERE "): string
    {
        $condition = '';
        $sqlQuery = '';


        if ( $Param != '' && $operator != '' )
        {
            $condition = $Param .  $operator ." :" . $Param;

            $sqlQuery .= $with . $condition;
        }

        return $sqlQuery;
    }
}