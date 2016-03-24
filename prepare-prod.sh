#!/bin/bash

# First, install composer and bower dependencies
composer -o install
rm src/AppBundle/Resources/public/vendor/* -Rf
bower install

# Cleanup
sudo php bin/console cache:clear --env=prod
sudo rm -Rf web/bundles web/css web/js

# Install assets
sudo php bin/console assets:install --env=prod
sudo php bin/console assetic:dump --env=prod

# Prime cache & unbork cache and log permissions
sudo php bin/console cache:warmup --env=prod
sudo chown www-data:www-data ../var/* -Rf
