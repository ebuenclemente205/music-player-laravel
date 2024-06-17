FROM php:8.2 as php

# Install required packages
RUN apt-get update -y && \
    apt-get install -y unzip libpq-dev libcurl4-gnutls-dev vim libfreetype6-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath && \
    docker-php-ext-configure pcntl --enable-pcntl && \
    docker-php-ext-install pcntl

# Install PECL redis extension
RUN pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis

# Set working directory
WORKDIR /var/www/musicplayer

# Copy application files
COPY . .

# Copy composer from another image
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

# Ensure entrypoint script has correct permissions
RUN chmod +x /var/www/musicplayer/docker/entrypoint.sh

# Set environment variable
ENV PORT=8000

# Set the entrypoint
ENTRYPOINT ["/var/www/musicplayer/docker/entrypoint.sh"]
