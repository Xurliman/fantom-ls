# deploy/Dockerfile

# stage 1: build stage
FROM php:8.3-fpm-alpine

# installing system dependencies and php extensions
RUN apk add --no-cache \
    zip \
    curl-dev libxml2-dev \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    oniguruma-dev \
    gettext-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    nodejs \
    npm \
    icu-dev \
    mariadb-client \
    nginx openrc

# openrc
VOLUME /sys/fs/cgroup

# Installing additional PHP modules
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install zip curl gd mbstring mysqli pdo pdo_mysql xml intl \
                            bcmath exif gettext opcache
RUN docker-php-ext-enable pdo_mysql gd


# install composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# Set working directory
RUN mkdir /var/www/fantom-ls
WORKDIR /var/www/fantom-ls
COPY . .


# copy necessary files and change permissions
RUN chown -R www-data:www-data /var/www/fantom-ls \
    && chmod -R 775 /var/www/fantom-ls/storage \
    && chmod -R 775 /var/www/fantom-ls/bootstrap/cache

# install php and node.js dependencies
###RUN composer install --no-dev --prefer-dist \
RUN composer install --prefer-dist \
    && npm install \
    && npm run build

RUN chown -R www-data:www-data /var/www/fantom-ls/vendor \
    && chmod -R 775 /var/www/fantom-ls/vendor


###CMD ["php-fpm"]

COPY ./deploy/nginx/http.d/default.conf /etc/nginx/http.d/default.conf
COPY ./deploy/php/php.ini "$PHP_INI_DIR/conf.d/"
RUN mv "$PHP_INI_DIR/conf.d/php.ini" "$PHP_INI_DIR/php.ini"

VOLUME /var/www/fantom-ls/storage/app

RUN mv -fin /var/www/fantom-ls/deploy/.env /var/www/fantom-ls/.env

# The following script runs every time the container starts
COPY ./deploy/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

## Run Laravel server
#CMD php artisan serve

#CMD ["sh", "-c", "nginx && php-fpm"]
