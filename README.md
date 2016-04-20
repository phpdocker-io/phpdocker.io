PHPDocker.io
============

[![Build Status](https://semaphoreci.com/api/v1/phpdockerio/phpdocker-io/branches/dev/badge.svg)](https://semaphoreci.com/phpdockerio/phpdocker-io)
[![Code Climate](https://codeclimate.com/github/phpdocker-io/phpdocker.io/badges/gpa.svg)](https://codeclimate.com/github/phpdocker-io/phpdocker.io)

This is the repository for both the website and the generator over at [PHPDocker.io](http://phpdocker.io), opensourced on an Apache 2.0 license and open for anyone to contribute as they please

Contributing
------------

The usual Github model of forking and pull request. Branch from and open PRs from the `dev` branch. There are no unit tests to keep an eye on, but until I get a functional suite testing ready, code merges can take a while. 

All I ask is to thoroughly test, manually, any changes made to the generators. You will need to run the containers with example apps to ensure they're working. Functional tests in the future will do precisely this, with a combination of PHP versions, frameworks, databases, etc. Setting this up is an area you could contribute on.

If you would like to add new containers, please either base them on `alpine` images, or `debian:jessie` as these are in use for the generated environments and will optimise deployment and provisioning to users.

Please follow PSR code formatting standards, and Symfony best practices and, in general, do what you see already done in the current code.

Please note everything is really in very early stages; if you see anything at all you can improve upon, please do so.

Running the project
-------------------

Project is given with a [PHPDocker.io](http://phpdocker.io) generated environment. 

  * Clone
  * Copy `app/config/parameters.yml.dist` into `app/config/parameters.yml`
  * `composer install`
  * `bower install`
  * `php bin/console assets:install --symlink --relative`
  * cd into the `phpdocker` folder and either `docker-compose up -d` or `vagrant up`. More specific information on [phpdocker/README.md](phpdocker/README.md).
  * You can then head off to the `/generator` route; you'll need to run `bin/console doctrine:schema:create` within the PHP container (or use the `console` script at the root of the project) to avoid SQL errors on the homepage

**Note:** you'll notice a `console` script at the root of the project. It does some voodoo to run `bin/console` within the container. There are several limitations however:
  * Needs fixing to properly work through vagrant as the `.vagrant` folder is not at the root of the project
  * It is not fully interactive. Any symfony commands that require user prompt after running the command (for instance, doctrine migrations) will not work
  * We really should bundle it on the generated environments for other people to use
