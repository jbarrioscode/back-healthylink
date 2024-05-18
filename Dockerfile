# Use PHP with Apache as the base image
FROM php:8.2

# Install systems dependencies
RUN apt-get update \
    && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    zlib1g-dev \
    libpq-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql zip bcmath gd

# Set working directory
WORKDIR /var/www/html

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy to root directory
#COPY --from=builder /app/vendor /var/www/vendor
COPY . .

# Create system user to run Composer and Artisan Commands
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

#CMD "composer install && php artisan serve --host=0.0.0.0 --port=8000"
CMD php artisan serve --host=0.0.0.0 --port=8000