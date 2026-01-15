# AI Agent Guide - PHPDocker.io

Welcome! This document provides essential context and instructions for AI agents working on the PHPDocker.io project.

## Project Overview

PHPDocker.io is a web-based generator for Docker environments tailored for PHP applications. This repository contains both the website and the generator core.

- **Primary Goal**: Provide an easy-to-use interface for generating `docker-compose.yaml` and related Dockerfiles for PHP projects.
- **Architecture**: Symfony-based web application.

## Tech Stack

- **PHP**: 8.4
- **Framework**: Symfony 7.0
- **Template Engine**: Twig
- **Frontend**: Managed via Yarn/NPM, assets served through Symfony Asset component.
- **Database/Storage**: Redis (for caching/sessions).
- **Environment**: Docker & Docker Compose.
- **Orchestration**: Kubernetes (deployment).

## Critical Workflows

### 1. Local Development Setup
The project uses a `Makefile` to automate environment setup.
```bash
make init
```
This command performs:
- Cache cleanup
- SSL certificate generation (using `mkcert`)
- Hosts file entry creation (`phpdocker.local`)
- Dependency installation (Composer & Yarn)
- Starting Docker containers

### 2. Common Commands
Always prefer using `make` commands to ensure consistent environment execution:
- `make start`: Start the environment.
- `make stop`: Stop the environment.
- `make shell`: Open a bash shell inside the PHP container.
- `make clear-cache`: Clear Symfony cache.

### 3. Testing & Quality
- **Static Analysis**: `make static-analysis` (runs PHPStan at level 9).
- **Unit Tests**: `make unit-tests` (runs PHPUnit).
- **Behavioral Tests**: `make behaviour` (runs Behat).
- **Coverage**: `make coverage-tests`.

## Coding Standards

- **PHP Standards**: Follow PSR-12 and Symfony best practices.
- **Strict Typing**: Use strict types in all new PHP files.
- **Static Analysis**: Ensure all changes pass PHPStan level 9.
- **Formatting**: Use existing project patterns for indentation and naming.

## Project Structure Highlights

- `src/PHPDocker/Generator`: Core logic for Docker environment generation.
- `src/Controller`: Symfony controllers for the web interface.
- `templates/`: Twig templates.
- `infrastructure/`: Docker and Kubernetes configuration files.
- `tests/`:
  - `Unit`: Small unit tests.
  - `Functional`: Symfony functional tests.
  - `Behat`: Feature-based behavioral tests.

## Deployment Information

Deployment is container-based:
- PHP-FPM image: `phpdockerio/site-php`
- Nginx image: `phpdockerio/site-ngx`
- Deployment target: Kubernetes (see `infrastructure/kubernetes`).

## Guidance for AI Agents

1. **Environment Awareness**: Always remember that the application runs inside Docker. Use `$(PHP_RUN)` (defined in Makefile as `docker compose run ...`) for executing PHP commands if you are running them from the host.
2. **Configuration**: Symfony configuration is located in `config/`. Environment variables are managed via `.env` and Symfony Dotenv.
3. **Tests**: When adding features to the generator, ensure you update or add tests in `tests/Functional/GeneratorTest.php` and relevant Behat features.
4. **Permissions**: If you encounter file permission issues in `var/`, use `make fix-cache-permissions-dev`.
