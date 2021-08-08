<?php

declare(strict_types=1);

namespace Tahir\App\Models;

use Tahir\Core\Main\Model;

class UsersModel extends Model
{

    protected const TABLESCHEMA = 'users';
    protected const TABLESCHEMAID = 'id';

    public function __construct()
    {
        parent::__construct(self::TABLESCHEMA, self::TABLESCHEMAID);
    }


}