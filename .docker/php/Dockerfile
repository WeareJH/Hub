FROM php:7.1-fpm
MAINTAINER Michael Woodward <michael@wearejh.com>

RUN apt-get update \
  && apt-get install -y \
    cron \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libxslt1-dev \
    gettext \
    msmtp \
    git

RUN docker-php-ext-configure \
  gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install \
  pdo_mysql \
  zip

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Xdebug
RUN pecl install -o -f xdebug-2.6.0
ADD etc/xdebug.template /usr/local/etc/php/conf.d/php-xdebug.template

ADD bin/docker-configure /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-configure

ENTRYPOINT ["/usr/local/bin/docker-configure"]
CMD ["php-fpm"]