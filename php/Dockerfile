FROM php:8.2-apache

RUN apt update

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer

COPY ./composer.json /var/www/html
# COPY ./composer.lock /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev

RUN ls .
COPY . /var/www/html