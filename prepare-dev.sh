#!/usr/bin/env bash
set -e

#
# This script will bootstrap the application for local development use. All the mucking about below around
# permissions and file ownerships are due to the fact we're running composer, bower etc through docker to avoid
# requiring from the contributors any dependencies (beyond docker and docker-compose) to be installed on their
# host system.
#

bold=$(tput bold)
normal=$(tput sgr0)
FIX_OWNERSHIP="sudo chown -Rf `id -u`:`id -g` . "
PHP_IN_CONTAINER="docker-compose exec php-fpm php "

echo -e "\n${bold} ## Preparing phpdocker.io for local dev ## \n${normal}"
echo -e "\n In order to fix up symfony cache permissions for both container and host, we'll need to sudo a few commands.\n"

PARAMETERS='config/parameters.yaml'
if [[ ! -f ${PARAMETERS} ]]; then
    echo -e "${bold}parameters.yaml file not found, creating...${normal}\n"
    cp ${PARAMETERS}.dist ${PARAMETERS}
else
    echo -e "${bold}parameters.yaml file present, leaving alone.${normal}\n"
fi

# Cleanup
${FIX_OWNERSHIP}

sudo rm -Rf public/bundles public/assets
sudo rm -Rf var/*

# Start up environment and run symfony console within container to ensure DB has the schema loaded up
# The environment contains a frontend builder so no need to do any frontend dep installs
docker-compose up -d

# Install composer deps
composer -o install

# Install assets
mkdir -p public/bundles
${PHP_IN_CONTAINER} bin/console assets:install --symlink --relative

# Recreate dev cache
${PHP_IN_CONTAINER} bin/console cache:warmup

# Load up DB schema
${PHP_IN_CONTAINER} bin/console doctrine:schema:update --force

# Ensure both container and host can write into the var/ folder
${FIX_OWNERSHIP}
sudo chmod -Rf 777 var/*

# Done!
echo -e "\n${bold} ## Application is now set up ${normal} for localdev, and the environment is up; head off to ${bold}>>> http://localhost:10000 <<< ## \n${normal}"
