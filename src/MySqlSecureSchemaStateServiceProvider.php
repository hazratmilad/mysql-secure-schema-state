<?php

namespace Milad\MySqlSecureSchemaState;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\MySqlSchemaState;

class MySqlSecureSchemaStateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MySqlSchemaState::class, MySqlSecureSchemaState::class);
    }
}
