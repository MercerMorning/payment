## Контейнеризация
1. git clone https://github.com/laradock/laradock.git laradock
2. cp ./laradock/.env.example ./laradock/.env
3. change PHP_VERSION in ./laradock/.env to 8.1
4. cp ./.env.example to ./.env
5. docker-compose up postgres workspace nginx php-fpm
6. docker exec -it laradock-workspace-1 bash
7. php bin/console doctrine:migrations:migrate

## Перед запуском автотестов
1. php bin/console --env=test doctrine:database:create
2. php bin/console --env=test doctrine:schema:create
3. php bin/console --env=test doctrine:migrations:migrate
4. php bin/console --env=test doctrine:fixtures:load