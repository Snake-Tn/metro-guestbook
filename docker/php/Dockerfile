FROM php:7.2-fpm

#install xdebug
RUN pecl install xdebug \
  && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)\n" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN pecl install redis \
 && echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini

#install libs
RUN apt-get update \
    && apt-get install -y \
    zip

#install exts
RUN docker-php-ext-install \
  pdo_mysql

#setup user access
RUN usermod -u 1000 www-data

#install composer
RUN curl https://getcomposer.org/installer  \
    | php -- --filename=composer --install-dir=/bin

RUN composer config --global repo.packagist composer https://packagist.org

WORKDIR /var/application/metro-guestbook