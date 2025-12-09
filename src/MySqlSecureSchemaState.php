<?php

namespace Milad\MySqlSecureSchemaState;

use Illuminate\Database\Schema\MySqlSchemaState;

class MySqlSecureSchemaState extends MySqlSchemaState
{
    protected function connectionString()
    {
        $value = ' --user="${:LARAVEL_LOAD_USER}" --password="${:LARAVEL_LOAD_PASSWORD}"';

        $config = $this->connection->getConfig();
        $useSsl = $config['dump']['use_ssl'] ?? false;
        $verifyCert = $config['dump']['verify_server_cert'] ?? null;

        $value .= $config['unix_socket'] ?? false
            ? ' --socket="${:LARAVEL_LOAD_SOCKET}"'
            : ' --host="${:LARAVEL_LOAD_HOST}" --port="${:LARAVEL_LOAD_PORT}"';

        /** @phpstan-ignore class.notFound */
        if (isset($config['options'][PHP_VERSION_ID >= 80500 ? \Pdo\Mysql::ATTR_SSL_CA : \PDO::MYSQL_ATTR_SSL_CA])) {
            $value .= ' --ssl-ca="${:LARAVEL_LOAD_SSL_CA}"';
        }

        if ($useSsl && ! $this->connection->isMaria()) {
            if (isset($config['options'][\PDO::MYSQL_ATTR_SSL_CERT])) {
                $value .= ' --ssl-cert="${:LARAVEL_LOAD_SSL_CERT}"';
            }

            if (isset($config['options'][\PDO::MYSQL_ATTR_SSL_KEY])) {
                $value .= ' --ssl-key="${:LARAVEL_LOAD_SSL_KEY}"';
            }
        }

        if ($verifyCert === false) {
            if (! $this->connection->isMaria()) {
                $value .= ' --ssl-verify-server-cert=OFF';
            }
        } elseif ($verifyCert === true) {
            if (! $this->connection->isMaria()) {
                $value .= ' --ssl-verify-server-cert=ON';
            }
        }

        return $value;
    }

    protected function baseVariables(array $config)
    {
        $config['host'] ??= '';

        return [
            'LARAVEL_LOAD_SOCKET' => $config['unix_socket'] ?? '',
            'LARAVEL_LOAD_HOST' => is_array($config['host']) ? $config['host'][0] : $config['host'],
            'LARAVEL_LOAD_PORT' => $config['port'] ?? '',
            'LARAVEL_LOAD_USER' => $config['username'],
            'LARAVEL_LOAD_PASSWORD' => $config['password'] ?? '',
            'LARAVEL_LOAD_DATABASE' => $config['database'],
            'LARAVEL_LOAD_SSL_CA' => $config['options'][PHP_VERSION_ID >= 80500 ? \Pdo\Mysql::ATTR_SSL_CA : \PDO::MYSQL_ATTR_SSL_CA] ?? '',
            'LARAVEL_LOAD_SSL_CERT' => $config['options'][\PDO::MYSQL_ATTR_SSL_CERT] ?? '',
            'LARAVEL_LOAD_SSL_KEY' => $config['options'][\PDO::MYSQL_ATTR_SSL_KEY] ?? '',
        ];
    }
}
