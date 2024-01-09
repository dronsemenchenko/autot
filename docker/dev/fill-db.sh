#!/bin/sh
cd /var/www/;
composer update;
php bin/console doctrine:schema:create;
php bin/console doctrine:fixtures:load -n;
bin/console --env=test doctrine:schema:create;
php bin/console --env=test doctrine:fixtures:load -n;