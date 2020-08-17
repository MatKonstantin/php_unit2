FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libpq-dev \
        libzip-dev \
        zip \
        procps \
        nano \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd 

RUN DEBIAN_FRONTEND=noninteractive curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off \
    && chmod 755 composer.phar && mv composer.phar /usr/local/bin/composer \
    && composer self-update

# ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www

CMD ["php-fpm"]