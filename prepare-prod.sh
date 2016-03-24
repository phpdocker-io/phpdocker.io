#!/bin/bash

# Cleanup
sudo rm -Rf web/bundles web/css web/js
sudo rm -Rf var/* -Rf
rm src/AppBundle/Resources/public/vendor/* -Rf

# Install composer and bower dependencies
composer -o install --no-dev --prefer-dist
bower install

# Install assets
sudo php bin/console assets:install --env=prod
sudo php bin/console assetic:dump --env=prod

# Prime cache & unbork cache and log permissions
sudo php bin/console cache:warmup --env=prod
sudo chown www-data:www-data var/* -Rf
