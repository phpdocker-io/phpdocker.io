PHPDocker.io
============

[![Build Status](https://semaphoreci.com/api/v1/phpdockerio/phpdocker-io/branches/dev/badge.svg)](https://semaphoreci.com/phpdockerio/phpdocker-io)
[![Code Climate](https://codeclimate.com/github/phpdocker-io/phpdocker.io/badges/gpa.svg)](https://codeclimate.com/github/phpdocker-io/phpdocker.io)

This is the repository for both the website and the generator over at [PHPDocker.io](http://phpdocker.io), opensourced on an Apache 2.0 license and open for anyone to contribute as they please

Contributing
------------

The usual Github model of forking and pull request. We're following trunk based development, so please create your branches against the `master` branch. There are no unit tests to keep an eye on, but until I get a functional suite testing ready, code merges can take a while.

All I ask is to thoroughly test, manually, any changes made to the generators. You will need to run the containers with example apps to ensure they're working. Functional tests in the future will do precisely this, with a combination of PHP versions, frameworks, databases, etc. Setting this up is an area you could contribute on.

If you would like to add new containers, please either base them on `alpine` images, `debian:jessie` (used by many official images such as MySQL, ElasticSearch...) or Ubuntu 16.04 as these are in use for the generated environments and will optimise deployment and provisioning to users.

Please follow PSR code formatting standards, and Symfony best practices and, in general, do what you see already done in the current code.

Please note everything is really in very early stages; if you see anything at all you can improve upon, please do so.

Running the project
-------------------

Project is given with a [PHPDocker.io](http://phpdocker.io) generated environment. 

I would recommend you install in your host php cli 7.1+, bower and composer and run the usual steps manually, but it's not necessary - the [`./prepare-dev.sh`](prepare-dev.sh) script will set up the app (bower install, composer install, etc) through docker and docker-compose commands.

  * Clone
  * Run [`./prepare-dev.sh`](prepare-dev.sh) - this will:
     * populate default dev config
     * composer and bower install
     * clean up caches
     * ensure web assets are available
     * load up the database schema (this is just for the CMS side of the website, it has no bearing over the generator)
     * start up the environment
  * You can then head off to the [/generator](http://localhost:10000/generator) route.

This is an initial fail-safe set up and not always you need to run it, after it's done once you'll just need to do a good old `docker-compose up -d`. More specific information on [phpdocker/README.md](phpdocker/README.md).

**Note:** you'll notice a `console` script at the root of the project. It does some voodoo to run `bin/console` within the container.
