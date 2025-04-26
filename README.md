# Matcher

[![CI](https://github.com/haspadar/matcher/actions/workflows/ci.yml/badge.svg)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Coverage](https://codecov.io/gh/haspadar/matcher/branch/main/graph/badge.svg)](https://codecov.io/gh/haspadar/matcher)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)
[![Pint Style](https://img.shields.io/badge/Code%20Style-PSR--12-blue)](https://github.com/laravel/pint)
[![License](https://img.shields.io/github/license/haspadar/matcher)](LICENSE)

---

## Build Status

- Continuous Integration via GitHub Actions.
- Automated Tests with PHPUnit.
- Code Coverage tracking via Codecov.

## Code Quality

- Static Analysis with PHPStan (Level 9)
- PSR-12 Coding Standard via PHP_CodeSniffer

## About
P2P matching engine for deposits and cashouts.
Designed for strict code quality, type safety, and clean architecture (DDD).

---

## Setup Git Hooks

After cloning the repository, run:

```bash
git config core.hooksPath .git-hooks

## Available Commands

| Command                  | Description                                 |
|--------------------------|---------------------------------------------|
| `composer install`       | Install PHP dependencies                    |
| `composer analyse`       | Run PHPStan static analysis                 |
| `composer cs`            | Run PHP_CodeSniffer (coding standards)      |
| `composer fix`           | Auto-fix code style issues (phpcbf)         | 
| `composer test`          | Run PHPUnit tests                           |
| `composer test-coverage` | Run PHPUnit tests with code coverage report |