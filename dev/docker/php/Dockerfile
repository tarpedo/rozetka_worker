FROM php:8.1-apache

RUN apt-get update && \
    apt-get upgrade -y

RUN apt-get install -y git \
    && git config --global user.email "tarpedo10@gmail.com" \
    && git config --global user.name "Oleksandr D."

RUN apt-get install -y mc

RUN apt-get install -y \
    libzip-dev \
    libxslt1-dev \
    libpng-dev \
    libonig-dev

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s \
      php-memcached-dev/php-memcached@v3.2.0RC2

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN mkdir -p /var/www/public \
    && chown -R www-data:www-data /var/www

ADD ./ssl/localhost.pem /etc/ssl/certs/localhost.pem
ADD ./ssl/localhost-key.pem /etc/ssl/private/localhost-key.pem

ADD ./apache2/localhost.conf /etc/apache2/sites-enabled/localhost.conf
ADD ./apache2/localhost-ssl.conf /etc/apache2/sites-enabled/localhost-ssl.conf

RUN a2enmod ssl
RUN a2dissite 000-default.conf
