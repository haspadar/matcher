# Matcher

[![CI](https://github.com/haspadar/matcher/actions/workflows/ci.yml/badge.svg)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Coverage](https://codecov.io/gh/haspadar/matcher/branch/main/graph/badge.svg)](https://codecov.io/gh/haspadar/matcher)
[![Mutation MSI](https://img.shields.io/badge/Mutation%20MSI-91%25-brightgreen)](https://infection.github.io/)

[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)
[![Psalm](https://img.shields.io/badge/psalm-level%208-brightgreen)](https://psalm.dev)
[![Pint Style](https://img.shields.io/badge/Code%20Style-PSR--12-blue)](https://github.com/laravel/pint)
[![Architecture](https://img.shields.io/badge/Architecture-Deptrac-brightgreen)](https://github.com/qossmic/deptrac)
[![PHP Metrics](https://img.shields.io/badge/Metrics-phpmetrics%203.0-blue)](https://phpmetrics.org/)

---

## Build Status

- Continuous Integration via GitHub Actions.
- Automated Tests with PHPUnit.
- Code Coverage tracking via Codecov.

## Code Quality

- Static Analysis with PHPStan (Level 9)
- Static Analysis with Psalm (Level 8)
- Code Formatting via Laravel Pint
- Architecture Rules enforced by Deptrac
- Mutational Testing via [Infection](https://infection.github.io/)

## About

P2P matching engine for deposits and cashouts.  
Designed for strict code quality, type safety, and clean architecture (DDD).

---

## Setup Git Hooks

After cloning the repository, run:

```bash
git config core.hooksPath .git-hooks
```

## Available Commands

| Command                  | Description                                          |
|--------------------------|------------------------------------------------------|
| `composer install`       | Install PHP dependencies                             |
| `composer analyse`       | Run PHPStan static analysis                          |
| `composer psalm`         | Run Psalm static analysis                            |
| `composer pint`          | Auto-fix code style issues (Laravel Pint)            |
| `composer pint-test`     | Check code style without fixing (Laravel Pint)       |1
| `composer test`          | Run PHPUnit tests                                    |
| `composer test-coverage` | Run PHPUnit tests with code coverage report          |
| `composer deptrac`       | Check architectural layer violations (Deptrac)       |
| `composer mutation`      | Run mutation testing with Infection                  |
| `composer metrics`       | Generate static code metrics report (PHP Metrics v3) |