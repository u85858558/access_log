FROM php:8.0-fpm-alpine
# lumen packages
RUN docker-php-ext-install tokenizer
#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
