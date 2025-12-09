<?php

namespace Milad\MySqlSecureSchemaState\Tests;

use Orchestra\Testbench\TestCase;
use Milad\MySqlSecureSchemaState\MySqlSecureSchemaState;
use Illuminate\Database\Connection;

class MySqlSecureSchemaStateTest extends TestCase
{
    public function test_base_variables_include_ssl()
    {
        $config = [
            'username' => 'root',
            'database' => 'forge',
            'options' => [
                \PDO::MYSQL_ATTR_SSL_CA => 'ca.pem',
                \PDO::MYSQL_ATTR_SSL_CERT => 'cert.pem',
                \PDO::MYSQL_ATTR_SSL_KEY => 'key.pem',
            ]
        ];

        $connection = $this->createMock(Connection::class);
        $connection->method('getConfig')->willReturn($config);
        $connection->method('isMaria')->willReturn(false);

        $state = new MySqlSecureSchemaState($connection);

        $method = new \ReflectionMethod($state, 'baseVariables');
        $vars = $method->invoke($state, $config);

        $this->assertEquals('ca.pem', $vars['LARAVEL_LOAD_SSL_CA']);
        $this->assertEquals('cert.pem', $vars['LARAVEL_LOAD_SSL_CERT']);
        $this->assertEquals('key.pem', $vars['LARAVEL_LOAD_SSL_KEY']);
    }
}
