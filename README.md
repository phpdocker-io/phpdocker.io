PHPDocker.io
============

This is the repository for both the website and the generator over at [PHPDocker.io](http://phpdocker.io), opensourced on an Apache 2.0 license and open for anyone to contribute as they please

Contributing
------------

Fork, tweak & pull request.

Please follow PSR code formatting standards, and Symfony best practices and, in general, do what you see already done in the current code.

Running the project
-------------------

Project is given with a [PHPDocker.io](http://phpdocker.io) generated environment. 

Recommended installation is running a `make init` script: this will set up the app (bower install, composer install, etc) through docker and docker-compose commands.

  * Clone
  * Run `make init` - this will:
     * clean up caches
     * provision a cert using `mkcert`
     * create a hosts entry (`phpdocker.local`)
     * composer and bower install
     * ensure web assets are available    
     * start up the environment

  * You can then head off to the [/generator](https://phpdocker.local:10000/generator) route.

This is an initial fail-safe set up and not always you need to run it, after it's done once you'll just need to do a good old `docker-compose up -d`.

Running the app on **Windows** is possible using Wsl2 and Docker. More info here: [Docker Desktop WSL 2 backend](https://docs.docker.com/docker-for-windows/wsl/). App will be available at [https://localhost:10000/generator](https://phpdocker.local:10000/generator) route.
