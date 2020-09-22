FROM php:7.4.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \ 
    libonig-dev \
    libmcrypt-dev \
    libxml2-dev \
    zip \
    unzip \
    mariadb-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && pecl install mcrypt-1.0.3


# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring
RUN docker-php-ext-enable imagick mcrypt

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer