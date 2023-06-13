FROM php:8.2-apache

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN apt update
RUN apt-get -y install libzip-dev
RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer

COPY composer.json /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

COPY . /var/www/html