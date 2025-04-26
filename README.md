# Matcher

[![CI](https://github.com/haspadar/matcher/actions/workflows/ci.yml/badge.svg)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)
[![License](https://img.shields.io/github/license/haspadar/matcher)](LICENSE)

---

## Build Status

- [![CI](https://github.com/haspadar/matcher/actions/workflows/ci.yml/badge.svg)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)

## Code Quality

- [![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)
- PSR-12 Coding Standard via PHPCS

## About
P2P matching engine for deposits and cashouts.
Designed for strict code quality, type safety, and clean architecture (DDD).

---

## Setup Git Hooks

After cloning the repository, run:

```bash
git config core.hooksPath .git-hooks

## Available Commands

| Command             | Description                           |
|---------------------|---------------------------------------|
| `composer install`  | Install PHP dependencies              |
| `composer analyse`  | Run PHPStan static analysis           |
| `composer cs`       | Run PHP_CodeSniffer (coding standards)|
| `composer fix`      | Auto-fix code style issues (phpcbf)   |
| `composer test`     | Run PHPUnit tests                     |