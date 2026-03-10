# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

PHPDocker.io is a Symfony 7 web application that generates Docker environments for PHP projects. Users fill out a form and receive a zip archive containing `docker-compose.yaml`, `Dockerfile`, nginx config, PHP ini, and a README.

**Tech stack:** PHP 8.4, Symfony 7.0, Twig, Redis (cache/sessions), Docker Compose (local), Kubernetes (production).

## Commands

All commands run via Docker containers. Use `make` targets rather than running PHP/vendor binaries directly on the host.

```bash
make init               # Full first-time setup (certs, hosts, deps, Docker build, start)
make start              # Start containers
make stop               # Stop containers
make shell              # Bash shell inside PHP container

make static-analysis    # PHPStan level 9 on src/
make unit-tests         # PHPUnit (no coverage)
make coverage-tests     # PHPUnit with xdebug coverage
make behaviour          # Behat behavioral tests

make clear-cache        # Clear Symfony var/ cache
make fix-cache-permissions-dev  # Fix var/ permissions if needed
```

**Running a single test file:**
```bash
docker compose run -e XDEBUG_MODE=coverage --rm php-fpm vendor/bin/phpunit tests/Functional/GeneratorTest.php
```

**Running a single Behat scenario:**
```bash
docker compose run -e XDEBUG_MODE=coverage --rm php-fpm vendor/bin/behat --colors --name="scenario name"
```

The app runs at `https://phpdocker.local:10000` after `make init`.

## Architecture

### Generator Flow

1. User submits the form at `/` (handled by `GeneratorController`)
2. `ProjectType` (Symfony Form) deserializes request into a `Project` model with nested service option objects (`MySQLOptions`, `PostgresOptions`, etc.)
3. `Generator` orchestrates file generation, delegating to individual file generators:
   - `Dockerfile.php`, `DockerCompose.php`, `NginxConf.php`, `PhpIni.php`, `Readme.php`
4. `Archiver` bundles the generated files into a zip and streams it to the browser

### Key Namespaces

- `App\PHPDocker\Generator\` — Core generation engine (file generators + orchestrator)
- `App\PHPDocker\Project\ServiceOptions\` — Service configuration models (MySQL, Postgres, Redis, etc.)
- `App\PHPDocker\PhpExtension\` — PHP extension metadata per version (8.2–8.5)
- `App\Form\Generator\` — Symfony Form types mirroring the domain models
- `App\Controller\` — Single `GeneratorController`

### Testing Structure

- `tests/Unit/` — Unit tests for isolated classes
- `tests/Functional/` — Symfony WebTestCase functional tests (`GeneratorTest.php` is the main one)
- `tests/Behat/` + `features/` — Behavioral tests via Behat/Mink with Symfony driver

When adding generator features, update `tests/Functional/GeneratorTest.php` and `features/generator.feature`.

## Coding Standards

- `declare(strict_types=1)` in every PHP file
- PHPStan level 9 — all changes must pass with zero errors
- PSR-12 + Symfony best practices
- Constructor property promotion with `readonly` where applicable

## Deployment

Container images are built via `make build-and-push` and deployed to Kubernetes via `make deploy`:
- PHP-FPM image: `phpdockerio/site-php`
- Nginx image: `phpdockerio/site-ngx`
- Kubernetes manifests: `infrastructure/kubernetes/`
