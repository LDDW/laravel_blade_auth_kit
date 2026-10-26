<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Docker Compose (dev)

This project ships a **dev-only** `docker-compose.yaml` with MySQL, Redis, Mailpit, and a queue worker. The Laravel app itself still runs on the host (`composer dev`); the worker container mounts this repo and processes `QUEUE_CONNECTION=database` jobs.

### Prerequisites

- Docker Engine + Compose v2
- A local `.env` (copy from `.env.example` if needed)

### Start / stop

```bash
docker compose up -d
docker compose ps
docker compose down
```

Data is stored in named Docker volumes (`auth_kit_*_data`). To wipe everything including data:

```bash
docker compose down -v
```

### `.env` configuration

| Variable | Role | Example |
| --- | --- | --- |
| `DB_CONNECTION` | Driver | `mysql` |
| `DB_HOST` | Host (app on host → container ports) | `127.0.0.1` |
| `DB_PORT` | MySQL port | `3306` |
| `DB_DATABASE` | Database name | `laravel` |
| `DB_USERNAME` | App DB user | `laravel` |
| `DB_PASSWORD` | App DB password (**required**) | strong secret |
| `DB_ROOT_PASSWORD` | MySQL root password for Compose (**required**, not used by Laravel) | strong secret |
| `FORWARD_DB_PORT` | Host → container MySQL port | `3306` |
| `REDIS_HOST` | Redis host | `127.0.0.1` |
| `REDIS_PORT` | Redis port | `6379` |
| `REDIS_PASSWORD` | Redis password (**required**) | strong secret |
| `FORWARD_REDIS_PORT` | Host → container Redis port | `6379` (use another port if busy, e.g. `6380`) |
| `MAIL_MAILER` | Mailer for Mailpit | `smtp` |
| `MAIL_HOST` | Mailpit SMTP | `127.0.0.1` |
| `MAIL_PORT` | Mailpit SMTP port | `1025` |
| `FORWARD_MAILPIT_SMTP_PORT` | Host → Mailpit SMTP | `1025` |
| `FORWARD_MAILPIT_UI_PORT` | Host → Mailpit UI | `8025` |

Keep `REDIS_PORT` equal to `FORWARD_REDIS_PORT` when the app runs on the host.

`REDIS_CLIENT=phpredis` expects the PHP extension `redis`. Install it on the host (e.g. `pecl install redis`) before using Redis for cache/queue/session.

Mailpit UI: [http://127.0.0.1:8025](http://127.0.0.1:8025)

### Security notes (even in local)

- All published ports bind to `127.0.0.1` only (not the LAN).
- MySQL and Redis refuse to start if passwords are missing from `.env`.
- Redis requires a password (`--requirepass`); containers use `no-new-privileges`.
- Do not commit `.env`. Change the placeholder passwords from `.env.example`.
- These services are for development; do not use this Compose file as-is in production.

### First MySQL setup

```bash
php artisan key:generate
php artisan migrate
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
