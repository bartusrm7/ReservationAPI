FROM php:8.2-apache

RUN a2enmod rewrite

RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

RUN apt-get update && apt-get install -y unzip git curl \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY . /var/www

WORKDIR /var/www
RUN composer install --no-dev --optimize-autoloader

RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

COPY .env /var/www/.env