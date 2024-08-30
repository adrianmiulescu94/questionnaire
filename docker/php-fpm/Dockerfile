FROM php:8.3-fpm-alpine


ARG USE_XDEBUG

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions ldap \
    pdo_mysql \
    @composer-2 \
    opcache

COPY ./conf.d/docker-php-ext-xdebug.ini $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini.default
COPY ./conf.d/docker-php-ext-opcache.ini $PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini
COPY ./conf.d/docker-php-dev-config.ini $PHP_INI_DIR/conf.d/docker-php-dev-config.ini

RUN if [ "$USE_XDEBUG" == 1 ]; then \
        install-php-extensions xdebug; \
        mv $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini.default $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini; \
    fi

RUN apk add grep \
    git

COPY ./php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm", "-R"]
