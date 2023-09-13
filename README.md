# dortrine-row-sec-demo
Demo Application using Doctrine with PostgreSQL Row Level Security

## Run Tests

```shell
php bin/console doctrine:database:create --connection=superuser
php bin/console doctrine:migrations:migrate --em=superuser
php bin/console doctrine:fixtures:load --em=superuser
```