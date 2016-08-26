<?php

namespace Adminka\Models;

use Dez\ORM\Model\QueryBuilder;
use Dez\ORM\Model\Table as ORMTable;

class Users extends ORMTable {

    static public function query()
    {
        return new QueryBuilder();
    }

}