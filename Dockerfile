FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

RUN a2enmod rewrite
RUN echo "ServerName db" >> /etc/apache2/apache2.conf
