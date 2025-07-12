#!/bin/bash
set -e
composer install --no-dev --optimize-autoloader
php bin/console cache:clear
php bin/console doctrine:migrations:migrate --no-interaction
