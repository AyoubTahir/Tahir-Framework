<?php

declare(strict_types=1);

namespace Tahir\Core\Database;

use Tahir\Core\Database\QueryManager;
use Tahir\Core\Database\PDOManager;
use Tahir\Core\Database\DatabaseConnection;

use Throwable;

class EntityManager
{
    protected string $query;
    protected array $parameters = [];
    protected $queryManager;
    protected $pdoManager;
    protected string $tableSchema;


    public function __construct(string $tableSchema, string $ID)
    {
        $cred =
        [
            'dsn' => 'mysql:host=localhost;port=3306;dbname=framework;charset=utf8mb4',
            'username' => 'root',
            'password' => '',
        ];

        $db = new DatabaseConnection($cred);
        $this->pdoManager   = new PDOManager($db);
        $this->queryManager = new QueryManager($tableSchema);
        
    }

    public function select( string $selectors = '*' ): self
    {
        $this->query = $this->queryManager->selectQuery($selectors);  
        
        return $this;
    }

    public function get()
    {
        $this->pdoManager->persist($this->query, $this->parameters);
        return $this->pdoManager->resultSet();
    }

    public function first()
    {
        $this->pdoManager->persist($this->query, $this->parameters);
        return $this->pdoManager->single();
    }

    public function where($key,$operator = '=',$value)
    {
        $this->parameters[$key] = $value;
        $this->query .= $this->queryManager->hasConditions($key,$operator); 
        return $this;

    }

    public function andWhere($key,$operator = '=',$value)
    {
        $this->parameters[$key] = $value;
        $this->query .= $this->queryManager->hasConditions($key, $operator, " and "); 

        return $this;

    }

    public function orWhere($key,$operator = '=',$value)
    {
        $this->parameters[$key] = $value;
        $this->query .= $this->queryManager->hasConditions($key,$operator, " or "); 

        return $this;

    }

    public function insert(array $fields): self
    {
        $this->parameters = $fields;
        $this->query = $this->queryManager->insertQuery($fields); 
        
        return $this;
    }

    public function update(array $fields): self
    {
        $this->parameters = $fields;
        $this->query = $this->queryManager->updateQuery($fields); 
        
        return $this;
    }

    public function delete(): self
    {
        $this->query = $this->queryManager->deleteQuery(); 

        return $this;
    }

    public function rawQuery($query,array $fields = []): self
    {
        $this->pdoManager->persist($query, $fields);

        return $this;

    }

    public function rawGet()
    {
        return $this->pdoManager->resultSet();
    }

    public function rawFirst()
    {
        return $this->pdoManager->single();
    }


    public function execute()
    {
        $this->pdoManager->persist($this->query, $this->parameters);
    }




}