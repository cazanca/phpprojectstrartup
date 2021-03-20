<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as Database;

class Model extends Database
{
    public function __construct()
    {
        Connect::getInstance();
    }
}
