# ---------
# COMPOSER
# ---------

FROM php:8.0.11-fpm as vendor

WORKDIR /app

# Composer installation
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update \
    && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev  libzip-dev zip

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-configure zip 

RUN docker-php-ext-install gd zip 

COPY ./api/database/ database/
COPY ./api/composer.json composer.json
COPY ./api/composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

COPY ./api .
RUN composer dump-autoload

# ---------
# SETUP
# ---------

FROM php:8.0.11-fpm as setup

# Starting from scratch
RUN apt-get clean && \ 
    apt-get -y autoremove && \ 
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Dependencies
RUN apt-get update

RUN apt-get install -y libfreetype6-dev \ 
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    libicu-dev \
    g++ \
    mariadb-client \
    supervisor \
    cron

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-configure intl

RUN docker-php-ext-install pdo_mysql \
    exif \
    pcntl \
    bcmath \
    intl \
    gd \
    opcache

RUN pecl install redis \
    && docker-php-ext-enable redis

# Custom php.ini config
COPY docker/prod/php/php.ini /usr/local/etc/php/php.ini
COPY docker/prod/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# ---- Unique for supervisor only ---->

# Prepare log files
RUN touch /var/log/cron.log \
    && touch /var/log/queue.log \
    && touch /var/log/supervisord.log

# Add supervisor configuration
COPY ./docker/prod/php/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./docker/prod/php/conf.d /etc/supervisor/conf.d

# Crontab
COPY ./docker/prod/php/cron.d/schedule /etc/cron.d
RUN chmod -R 644 /etc/cron.d \
    && crontab /etc/cron.d/schedule

# <---- Unique for supervisor only ----

# Clean up
RUN apt-get clean \
    && apt-get -y autoremove \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./api /var/www/api

# Copy Composer dependencies
COPY --from=vendor /app/vendor /var/www/api/vendor

# Set up default directory
WORKDIR /var/www/api

RUN chown -R www-data:www-data \
    /var/www/api/storage \
    /var/www/api/bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache       

RUN php artisan storage:link \
    && php artisan optimize