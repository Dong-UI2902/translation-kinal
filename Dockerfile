FROM php:8-fpm-alpine

COPY composer.lock composer.json /var/www/
COPY database /var/www/database

RUN apk upgrade --update && apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev supervisor

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

# Remove Cache
RUN rm -rf /var/cache/apk/*

RUN docker-php-ext-install iconv sockets exif pcntl
RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php --\
        --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY .docker/supervisor/supervisord.conf /etc/supervisord.conf
COPY .docker/supervisor/config /etc/supervisor.d

COPY . /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

#TODO: Local env & production env
#ENTRYPOINT ["sh", "/var/www/.docker/entrypoint.sh"]

CMD supervisord -n -c /etc/supervisord.conf
