FROM php:8.5-cli-bookworm

RUN docker-php-ext-install pdo_mysql pcntl

WORKDIR /var/www/html

CMD ["php", "artisan", "queue:work", "--sleep=1", "--tries=3", "--max-time=3600"]
