<?php

declare(strict_types=1);

namespace Tahir\Core\Main;

use Tahir\Core\Database\EntityManager;

class Model extends EntityManager
{

    private string $table;
    private string $ID;

    public function __construct(string $table, string $ID)
    {
        parent::__construct( $table, $ID );
    }
/*
    public function getRepo() : DataRepository
    {
        return $this->repository;
    }*/


}