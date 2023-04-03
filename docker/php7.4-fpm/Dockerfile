FROM php:7.4-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y git unzip openssl procps acl zlib1g-dev libzip-dev cron libicu-dev
RUN curl -fsSL https://deb.nodesource.com/setup_19.x | bash - && apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Install extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl pdo pdo_mysql bcmath zip

# Install AMQP
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

# Install Redis extension
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

# Install xdebug
RUN pecl install xdebug-3.1.5
RUN docker-php-ext-enable xdebug

RUN echo 'alias symfony="php bin/console"' >> ~/.bashrc

RUN chmod 777 /var/www/html

COPY docker/php7.4-fpm/cron.d /etc/cron.d
RUN chmod 0644 /etc/cron.d/crontab
RUN chmod 775 /var/www/html
RUN crontab /etc/cron.d/crontab
RUN touch /var/log/crontest.log && chmod 777 /var/log/crontest.log

WORKDIR /var/www/html
