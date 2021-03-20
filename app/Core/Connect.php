<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Connect
{
    protected static Capsule $capsule;

    public static function getInstance()
    {
        if (empty(self::$capsule)) {
            try {
                self::$capsule = new Capsule();
                self::$capsule->addConnection([
                    'driver'    => 'mysql',
                    'host'      => DB_CONFIG['HOST'],
                    'database'  => DB_CONFIG['NAME'],
                    'username'  => DB_CONFIG['USER'],
                    'password'  => DB_CONFIG['PASS'],
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ]);

                self::$capsule->setEventDispatcher(new Dispatcher(new Container));

                // Makeself::$capsuleinstance available globally via static methods... (optional)
                self::$capsule->setAsGlobal();

                // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
                self::$capsule->bootEloquent();
            } catch (\Exception $e) {
                redirect("/erro/problemas");
            }
        }

        return self::$capsule;
    }

    final private function __construct()
    {
    }
    final private function __clone()
    {
    }
}
