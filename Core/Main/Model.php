<?php

declare(strict_types=1);

namespace Tahir\Core\Main;

use Tahir\Core\Database\RepositoryManager;

class Model extends RepositoryManager
{

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