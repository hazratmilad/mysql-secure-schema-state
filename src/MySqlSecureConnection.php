<?php

namespace Milad\MySqlSecureSchemaState;

use Illuminate\Database\MySqlConnection;

class MySqlSecureConnection extends MySqlConnection
{
    /**
     * Get the schema state for the connection.
     *
     * @param  \Illuminate\Filesystem\Filesystem|null  $files
     * @param  callable|null  $processFactory
     * @return MySqlSecureSchemaState
     */
    public function getSchemaState($files = null, callable $processFactory = null): MySqlSecureSchemaState
    {
        return new MySqlSecureSchemaState(
            $this,
            $files,
            $processFactory
        );
    }
}