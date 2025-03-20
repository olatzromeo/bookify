FROM php:8.2-fpm
ARG TIMEZONE
ARG UID

RUN adduser -u ${UID} --disabled-password --gecos "" appuser \
    && mkdir /home/appuser/.ssh \
    && chown -R appuser:appuser /home/appuser/ \
    && echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config \
    && echo "export COLUMNS=300" >> /home/appuser/.bashrc \
    && echo "alias sf=/var/www/bookify/bin/console" >> /home/appuser/.bashrc

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev \
    libxslt1-dev \
    acl \
    libjpeg62-turbo-dev \
    libonig-dev \
    librabbitmq-dev \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install amqp \
    && docker-php-ext-enable amqp

RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN curl -fsSL https://xdebug.org/files/xdebug-3.2.1.tgz -o xdebug.tgz \
    && tar -xvzf xdebug.tgz \
    && cd xdebug-3.2.1 \
    && phpize \
    && ./configure \
    && make && make install \
    && docker-php-ext-enable xdebug \
    && cd .. && rm -rf xdebug.tgz xdebug-3.2.1

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install xsl
RUN docker-php-ext-install gd
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-install exif
RUN docker-php-ext-install mbstring

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo ${TIMEZONE} > /etc/timezone

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/www/bookify
WORKDIR /var/www/bookify

USER appuser