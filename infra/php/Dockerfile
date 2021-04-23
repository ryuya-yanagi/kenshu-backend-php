FROM php:7.3-apache

# Setting
ADD ./php.ini /usr/local/etc/php/
ADD ./default.conf /etc/apache2/sites-enabled/

# Install middleware
RUN apt-get update \
  && apt-get install -y \
  git \
  zip \
  unzip \
  vim \
  libpng-dev \
  libpq-dev \
  && docker-php-ext-install pdo_mysql