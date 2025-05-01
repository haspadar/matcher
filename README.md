# Matcher

[![CI](https://github.com/haspadar/matcher/actions/workflows/ci.yml/badge.svg)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Coverage](https://codecov.io/gh/haspadar/matcher/branch/main/graph/badge.svg)](https://codecov.io/gh/haspadar/matcher)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)
[![Psalm](https://img.shields.io/badge/psalm-level%208-brightgreen)](https://psalm.dev)
[![Pint Style](https://img.shields.io/badge/Code%20Style-PSR--12-blue)](https://github.com/laravel/pint)

---

## Build Status

- Continuous Integration via GitHub Actions.
- Automated Tests with PHPUnit.
- Code Coverage tracking via Codecov.

## Code Quality

- Static Analysis with PHPStan (Level 9)
- Static Analysis with Psalm (Level 8)
- PSR-12 Coding Standard via PHP_CodeSniffer
- Code Formatting via Laravel Pint
- Code Smell Detection via PHP Mess Detector (phpmd 3.x)

## About

P2P matching engine for deposits and cashouts.
Designed for strict code quality, type safety, and clean architecture (DDD).

---

## Setup Git Hooks

After cloning the repository, run:

```bash
git config core.hooksPath .git-hooks

To run phpmd with PHP 8.3+ support and suppressed deprecation warnings:

```bash
composer phpmd

## Available Commands

| Command                   | Description                                     |
|---------------------------|-------------------------------------------------|
| `composer install`         | Install PHP dependencies                       |
| `composer analyse`         | Run PHPStan static analysis                    |
| `composer psalm`           | Run Psalm static analysis                      |
| `composer pint`            | Auto-fix code style issues (Laravel Pint)      |
| `composer pint-test`       | Check code style without fixing (Laravel Pint) |
| `composer test`            | Run PHPUnit tests                              |
| `composer test-coverage`   | Run PHPUnit tests with code coverage report    |
| `composer phpmd`           | Run PHP Mess Detector with custom ruleset      |