FROM php:7.2-fpm

#install libs
RUN apt-get update \
    && apt-get install -y \
    zip libyaml-dev

#install xdebug ext
RUN pecl install xdebug \
  && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)\n" >> /usr/local/etc/php/conf.d/xdebug.ini

#install xdebug ext
RUN pecl install redis \
 && echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini


#install yaml ext
RUN pecl install yaml \
  && echo "extension=yaml.so" >> /usr/local/etc/php/conf.d/yaml.ini
#install exts
RUN docker-php-ext-install \
  pdo_mysql

#setup user access
RUN usermod -u 1000 www-data

ENV PATH="/var/application/metro-guestbook/bin:${PATH}"

#install composer
RUN curl https://getcomposer.org/installer  \
    | php -- --filename=composer --install-dir=/bin

RUN composer config --global repo.packagist composer https://packagist.org

WORKDIR /var/application/metro-guestbook