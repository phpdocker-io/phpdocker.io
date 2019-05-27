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
SUDO_NOT_FOUND="echo -e \n${bold} ## WARNING: The following command requested elevated access but sudo is not installed. ## ${normal}"

echo -e "\n${bold} ## Preparing phpdocker.io for local dev ## \n${normal}"
echo -e "\n In order to fix up symfony cache permissions for both container and host, we'll need to sudo a few commands.\n"

PARAMETERS='app/config/parameters.yml'
if [[ ! -f ${PARAMETERS} ]]; then
    echo -e "${bold}parameters.yml file not found, creating...${normal}\n"
    cp ${PARAMETERS}.dist ${PARAMETERS}
else
    echo -e "${bold}parameters.yml file present, leaving alone.${normal}\n"
fi

# Address environments that dont have sudo installed (CYGWIN/MINGW/ect)
hash sudo 2>/dev/null || sudo(){ ${SUDO_NOT_FOUND}; $@; }

# Cleanup
${FIX_OWNERSHIP}

sudo rm -Rf web/bundles web/css web/js
sudo rm -Rf var/*
rm -Rf src/AppBundle/Resources/public/vendor/*

# Install static assets through bower
if hash bower 2>/dev/null; then
    bower install
else
    echo -e "\n${bold}Bower not found, running through docker run (much slower)...${normal}\n"

    docker run  \
        --rm \
        -it \
        -v "`pwd`:/workdir" \
        -w /workdir \
        node:alpine \
        sh -c "apk update; apk add git; npm i -g bower; bower install --allow-root"

    ${FIX_OWNERSHIP}
fi

# Start up environment and run symfony console within container to ensure DB has the schema loaded up
docker-compose up -d

# Install composer deps
composer -o install

# Install assets
mkdir -p web/bundles web/css web/js
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
