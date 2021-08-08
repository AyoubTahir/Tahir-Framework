<?php

declare(strict_types=1);

namespace Tahir\Core\Database;

use Tahir\Core\Database\Exception\DatabaseConnectionException;

use PDOException;
use PDO;

class DatabaseConnection
{

    protected PDO $dbh;
    protected array $credentials;



    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }


    public function open() : PDO
    {
        try
        {
            
            $this->dbh = new PDO(
                $this->credentials['dsn'],
                $this->credentials['username'],
                $this->credentials['password'],
                $this->pdoParams()
            );

        }
        catch(PDOException $expection)
        {
            throw new DatabaseConnectionException($expection->getMessage(), (int)$expection->getCode());
        }

        return $this->dbh;
    }

    public function close() : void
    {
        $this->dbh = null;
    }

    private function pdoParams() : array
    {
        return [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
    }


}