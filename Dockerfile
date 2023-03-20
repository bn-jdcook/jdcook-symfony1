FROM php:8.1-cli

RUN docker-php-ext-install -j$(nproc) pdo_mysql opcache

RUN mkdir /code && apt-get update && apt-get install -y \
        wget \
        zip \
    && bash -c "wget https://getcomposer.org/installer && php ./installer && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer"

WORKDIR /code

COPY . .
RUN composer install --no-interaction
