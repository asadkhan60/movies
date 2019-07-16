FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        cron \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

RUN pecl install mongodb-1.5.3 \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/docker-php-ext-mongodb.ini \
    && pecl install apcu-5.1.12 \
    && echo "extension=apcu.so" >> /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini \
    && pecl install xdebug-2.7.0beta1

#COPY php.ini /usr/local/etc/php/conf.d/
#COPY log/cron.log /var/log/

#RUN echo "* 04 * * * /usr/local/bin/php /var/www/movies/bin/console app:update-movies >> /var/log/cron.log 2>&1" > /etc/cron.d/cron
#RUN chmod 0777 /var/log/cron.log

#ADD cron /etc/cron.d/cron
#RUN crontab /etc/cron.d/cron
#CMD ["cron", "-f"]

#RUN crontab -l > mycron
#RUN echo "* 04 * * * /usr/local/bin/php /var/www/movies/bin/console app:update-movies >> /var/log/cron.log 2>&1" >> mycron
#RUN crontab mycron
#RUN rm mycron
#CMD ["cron", "-f"]

RUN apt-get install -y git
RUN apt-get install -y nano

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

#RUN composer require alcaeus/mongo-php-adapter \
#    && composer require doctrine/mongodb-odm-bundle
