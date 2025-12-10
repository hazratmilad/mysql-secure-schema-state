<?php

namespace Milad\MySqlSecureSchemaState;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;

class MySqlSecureSchemaStateServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register custom MySQL connection resolver
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config) {
            return new MySqlSecureConnection($connection, $database, $prefix, $config);
        });
    }
}