# Doctrine Row Level Security Demo

Demo Application using Doctrine with PostgreSQL Row Level Security.

This is a proof-of-concept
that [Multi-tenant data isolation with PostgreSQL Row Level Security](https://aws.amazon.com/blogs/database/multi-tenant-data-isolation-with-postgresql-row-level-security/)
described by AWS can work in PHP using Doctrine.

## Requirements

This demo needs at least PHP 8.1 and Composer as well as a PostgreSQL database with credentials for two users:

* root user (table owner) that is not restricted by security policies
* application user that has the usual permissions needed to query the database

## Setup Environment

Create a file named `env.local` like the example and define both connection strings

```shell
DATABASE_SUPERUSER="postgresql://root_user_name:root_user_password@database-host.example.com:5432/db_name?serverVersion=11&charset=utf8"
DATABASE_APP="postgresql://application_useR_name:applicatin_user_password@database-host.example.com::5432/db_name?serverVersion=11&charset=utf8"
```

Then set up the PHP application and load fixtures into the database.

```shell
composer install
php bin/console doctrine:database:create --connection=superuser
php bin/console doctrine:migrations:migrate --em=superuser
php bin/console doctrine:fixtures:load --em=superuser
```

## Run Tests

This application provides tests for all scenarios described in the AWS blog. To execute the tests run:

```shell
./bin/phpunit
```

## How Does it Work?

A Doctrine migration will create two tables: `Tenant` and `TenantUser`. Each table has a policy that will only return
tenants (and their respective users) if the tenant's ID matches the parameter `app.current_tenant`.

If the application sets this parameter to the value of the current tenant then the database will only return data for
this exact tenant. All other tenants (and their users) will be invisible.

See `src/Middleware` for the single magic step that is needed for Doctrine.