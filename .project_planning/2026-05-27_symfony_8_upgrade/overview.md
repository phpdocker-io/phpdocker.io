# Upgrade to Symfony 8.0 and Latest Dependencies

## Request

Upgrade the PHPDocker.io application to the newest stable Symfony version and bump all other dependencies to their latest compatible versions.

## Overview

**Current state:**
- Symfony locked at **7.4.7**, `composer.json` requires `^7.0`
- PHP **8.5.4** (requirement `8.5.*`)
- PHPUnit **^12.0**, PHPStan **^1.4**, Twig **^3.0**
- Behat behavioural tests via `friends-of-behat/*` packages (20 scenarios)

**Target state:**
- Symfony **8.0.12** (latest stable; 8.1 is still in beta)
- PHPUnit **^13.1**, PHPStan **^2.1**, Twig **^3.23** (already current)
- All Symfony package constraints updated from `^7.0` to `8.0.*`
- `symfony.lock` recipe versions updated
- `phpunit.xml.dist` schema updated to PHPUnit 13.x
- Behat suite **migrated to PHPUnit functional tests** and removed

**Key breaking changes:** Symfony 8.0 has an extensive 865-line UPGRADE-8.0.md. The highest-risk areas for this codebase are:
- `Url` validator constraint default change (`$requireTld` → `true`)
- `Request::get()` removal (unlikely used; project uses form submission)
- `Command` attribute/class changes (if any custom CLI commands exist)
- TwigBundle `base_template_class` removal (config file may need update)

**Behat migration:**
The 20 Behat scenarios in `features/generator.feature` cover form validation, zip generation, service toggles, and default-generation flows. These must be rewritten as PHPUnit `WebTestCase` tests in `tests/Functional/GeneratorTest.php`. The entire Behat stack (`friends-of-behat/*`, `behat/behat`, `beberlei/assert`) will then be removed.

## Verification Strategy

| Command | Purpose | Cost | Notes |
|---|---|---|---|
| `make static-analysis` | PHPStan level 9 across `src/` and `tests/` | Medium | Must pass with zero errors |
| `make unit-tests` | PHPUnit without coverage | Medium | Must pass with zero failures |
| `make coverage-tests` | PHPUnit with xdebug coverage | Expensive | Verify coverage thresholds if any |
| `composer validate` | Validate `composer.json` | Cheap | Run after edits |
| `composer audit` | Check for security advisories | Cheap | Run after update |

All commands run inside the PHP-FPM Docker container via `make` targets, per `AGENTS.md`.

## Decision Log

1. **Symfony target version:** 8.0.12 (stable), not 8.1 beta. Rationale: 8.1 is not production-ready.
2. **PHP version:** Keep `8.5.*`. Symfony 8.0 requires `>=8.4`, so 8.5 is fully compatible.
3. **Behat strategy:** Migrate all 20 scenarios to PHPUnit functional tests, then remove the Behat dependency stack. Rationale: `friends-of-behat/*` and `behat/behat` 3.x do not support Symfony 8.x; no alternative ecosystem exists today.
4. **PHPStan:** Upgrade from 1.x to 2.x. May introduce new rules; `phpstan.neon` may need tweaks.
5. **PHPUnit:** Upgrade from 12.x to 13.x. `phpunit.xml.dist` schema URL and attributes may need updates.
6. **Scope:** Do not upgrade PHP version (already 8.5), do not change application features, do not add new services.
