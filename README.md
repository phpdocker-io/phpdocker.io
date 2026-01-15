PHPDocker.io
============

PHPDocker.io is a web-based generator for Docker environments tailored for PHP applications. This repository contains both the website and the generator core, open-sourced under the Apache 2.0 license.

Visit us at [phpdocker.io](https://phpdocker.io).

Tech Stack
----------

- **PHP**: 8.4
- **Framework**: Symfony 7.0
- **Frontend**: Yarn / Symfony Asset
- **Storage**: Redis
- **Environment**: Docker & Docker Compose

Contributing
------------

Fork, tweak & pull request.

Please follow PSR-12 code formatting standards, Symfony best practices, and maintain strict typing. Ensure all changes pass static analysis at level 9.

See [AGENTS.md](./AGENTS.md) for a more detailed guide for developers and AI agents.

Running the project
-------------------

The project comes with its own PHPDocker.io generated environment.

### Prerequisites

- Docker and Docker Compose
- `mkcert` (for local SSL)
- `make`

### Installation

The recommended installation is running the `make init` script. This will automate the setup through Docker:

```bash
make init
```

This command performs the following:
- Cleans up caches
- Provisions a local SSL certificate using `mkcert`
- Creates a hosts entry (`phpdocker.local`)
- Installs PHP dependencies via Composer
- Installs JS dependencies via Yarn
- Installs web assets
- Starts up the Docker environment

Once finished, the application will be available at [https://phpdocker.local:10000](https://phpdocker.local:10000). You can head directly to the [/generator](https://phpdocker.local:10000/generator) route.

### Common Commands

- `make start`: Start the environment.
- `make stop`: Stop the environment.
- `make shell`: Open a bash shell inside the PHP container.
- `make static-analysis`: Run PHPStan (level 9).
- `make unit-tests`: Run PHPUnit.
- `make behaviour`: Run Behat tests.

### Windows Support

Running the app on **Windows** is possible using WSL2 and Docker. More info here: [Docker Desktop WSL 2 backend](https://docs.docker.com/docker-for-windows/wsl/). The app will be available at [https://localhost:10000](https://localhost:10000).
