# 🧩 Matcher

[![PHP Version](https://img.shields.io/badge/PHP-8.4-blue)](https://www.php.net/releases/8.4/)
[![Pint Style](https://img.shields.io/badge/Code%20Style-PSR--12-blue)](https://github.com/laravel/pint)
[![CI](https://github.com/haspadar/matcher/actions/workflows/ci.yml/badge.svg)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![PHP Metrics](https://img.shields.io/badge/Metrics-phpmetrics%203.0-blue)](https://phpmetrics.org/)
[![Architecture](https://img.shields.io/badge/Architecture-Deptrac-brightgreen)](https://github.com/qossmic/deptrac)

[![Tests](https://img.shields.io/badge/Tests-Passing-brightgreen)](https://github.com/haspadar/matcher/actions/workflows/ci.yml)
[![Coverage](https://codecov.io/gh/haspadar/matcher/branch/main/graph/badge.svg)](https://codecov.io/gh/haspadar/matcher)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)
[![Psalm](https://img.shields.io/badge/psalm-level%208-brightgreen)](https://psalm.dev)
[![Psalm Type Coverage](https://shepherd.dev/github/haspadar/matcher/coverage.svg)](https://shepherd.dev/github/haspadar/matcher)
[![Mutation MSI](https://img.shields.io/badge/Mutation%20MSI-100%25-brightgreen)](https://infection.github.io/)

---

## 📦 О проекте

`Matcher` — демо-движок для подбора P2P-депозитов и выплат.  
Проект построен на принципах чистой архитектуры (DDD), с упором на типобезопасность, читаемость и контроль качества.

---

## ⚙️ Статус сборки

- CI на базе GitHub Actions
- Автотесты с PHPUnit
- Покрытие кода отслеживается через Codecov

---

## 🧪 Качество кода

- Статический анализ через PHPStan (уровень 9)
- Анализ типов через Psalm (уровень 8)
- Проверка и автоформатирование кода через Laravel Pint
- Архитектурные границы проверяются с помощью Deptrac
- Мутационное тестирование через [Infection](https://infection.github.io/)

---

## 🚀 Установка Git хуков

После клонирования репозитория:

```bash
git config core.hooksPath .git-hooks
```

## 🛠 Доступные команды

| Command                  | Description                                       |
|--------------------------|---------------------------------------------------|
| `composer install`       | Установка зависимостей                            |
| `composer analyse`       | Запуск PHPStan                                    |
| `composer psalm`         | Запуск Psalm                                      |
| `composer pint`          | Автоисправление стиля кода (Laravel Pint)         |
| `composer pint-test`     | Проверка кода без изменений  (Laravel Pint)       |
| `composer test`          | Запуск юнит-тестов                                |
| `composer test-coverage` | Запуск юнит-тестов с отчётом покрытия             |
| `composer deptrac`       | Проверка архитектурных ограничений (Deptrac)      |
| `composer mutation`      | Мутационное тестирование через Infection          |
| `composer metrics`       | Генерация отчёта по метрикам кода (PHP Metrics 3) |

## 📘 Документация

- [💬 Единый язык (Glossary)](docs/glossary.md)
````