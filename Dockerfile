FROM php:8.2-cli-bookworm

# Enable Composer inside the container (avoids downloading each time).
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install extensions and tools needed by the kata and for coverage reports.
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends git unzip libzip-dev; \
    docker-php-ext-install zip; \
    pecl install xdebug; \
    docker-php-ext-enable xdebug; \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Keep the container alive for interactive use; commands are run via `docker compose run`.
CMD ["sleep", "infinity"]
