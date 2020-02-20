#!/bin/sh

cd /application

if [ ! -f ./.env ]; then
    cp ./.env.example ./.env
fi

composer install

chmod 0777 -R storage
chmod 0777 -R bootstrap/cache

php artisan key:generate
php artisan migrate:install
php artisan migrate


#./bin/console doctrine:database:create --if-not-exists
#./bin/console doctrine:migrations:migrate
#./bin/console doctrine:fixtures:load
#
#./bin/console doctrine:database:create --env=test --if-not-exists
#./bin/console doctrine:migrations:migrate --env=test

/usr/bin/supervisord -n
