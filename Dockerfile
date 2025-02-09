FROM php:8.2-apache


RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-install zip pdo_mysql


COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer


COPY . /var/www/html


RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html


COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite


EXPOSE 80


CMD ["apache2-foreground"]
