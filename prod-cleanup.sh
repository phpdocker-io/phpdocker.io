#!/usr/bin/env bash

sudo rm /tmp/phpdocker.io/* -Rf
sudo php bin/console cache:clear --env=prod
sudo rm -Rf web/bundles web/css web/js
sudo php bin/console assets:install --env=prod
sudo php bin/console assetic:dump --env=prod
sudo chown www-data:www-data /tmp/phpdocker.io/* -Rf
sudo /home/ubuntu/bin/restart-webserver
curl -sS http://phpdocker.io > /dev/null
curl -sS http://phpdocker.io/generator > /dev/null
