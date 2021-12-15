# docker/Dockerfile
FROM php:7.4-fpm

ARG APCU_VERSION=5.1.18

LABEL Maintainer="Testing..." \
      Description="Base setup for web development with PHP and PostgreSQL."

# Get frequently used tools
RUN apt-get update && apt-get install -y \
    build-essential \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    zip \
    unzip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl \
    wget \
    zsh \
    libpq-dev \
    libxslt1-dev \
    redis

RUN docker-php-ext-configure zip

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
   docker-php-ext-install pdo \ 
    pdo_pgsql \ 
    pgsql 

#GET AMQP
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

RUN docker-php-ext-install xsl\
        bcmath \
        mbstring \
        pcntl \
        intl \
        zip \
        opcache \
        gd

# apcu for caching, xdebug for debugging and also phpunit coverage
RUN pecl install \
        apcu-${APCU_VERSION} \
        xdebug \
    && docker-php-ext-enable \
        apcu \
        xdebug


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# php-cs-fixer tool
RUN wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O /usr/local/bin/php-cs-fixer
RUN chmod +x /usr/local/bin/php-cs-fixer


# Copy existing app directory
COPY . /var/www
WORKDIR /var/www


# Configure non-root user.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data


# Copy and run composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash
# RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

EXPOSE 9000

CMD ["php-fpm"]