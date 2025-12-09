# MySQL Secure Schema State for Laravel
### SSL-enabled, MySQL-enhanced schema dumps with MariaDB safety

This package overrides Laravel's `MySqlSchemaState` to provide full SSL support when dumping
MySQL schemas using `mysqldump`, while protecting MariaDB users from unsupported flags.

## ✨ Features

- SSL CA / CERT / KEY support
- Optional SSL verification toggles
- Automatically disabled for MariaDB
- Drop-in replacement for Laravel's SchemaState
- No framework modifications required

## 📦 Installation

```bash
composer require milad/mysql-secure-schema-state
