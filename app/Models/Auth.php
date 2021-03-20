<?php

namespace App\Models;

use App\Core\Model;

class Auth extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password'
    ];

    // optionals - id autoincrement
    //public $incrementing = true;
    //public $timestamps = false;

}
