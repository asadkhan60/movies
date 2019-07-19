FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        sudo \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

RUN useradd -m khan && echo "khan:khan" | chpasswd && adduser khan sudo

RUN pecl install mongodb-1.5.3 \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/docker-php-ext-mongodb.ini \
    && pecl install apcu-5.1.12 \
    && echo "extension=apcu.so" >> /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini \
    && pecl install xdebug-2.7.0beta1

RUN apt-get install -y git

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

#RUN composer require alcaeus/mongo-php-adapter \
#    && composer require doctrine/mongodb-odm-bundle

USER khan