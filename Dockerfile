FROM php:7.0-apache

RUN apt-get update && \
    apt-get clean

COPY src /var/www/html/
