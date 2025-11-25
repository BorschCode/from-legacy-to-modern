FROM php:5.6-apache

# Update to use Debian archive repositories since Stretch is EOL
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list

# Install system dependencies
# Use --allow-unauthenticated because Debian Stretch GPG keys have expired
RUN apt-get update && apt-get install -y --allow-unauthenticated \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Configure PHP timezone
RUN echo "date.timezone = UTC" > /usr/local/etc/php/conf.d/timezone.ini

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Download and extract CodeIgniter 3.1.13 system files
RUN curl -L https://github.com/bcit-ci/CodeIgniter/archive/refs/tags/3.1.13.tar.gz -o /tmp/ci.tar.gz \
    && tar -xzf /tmp/ci.tar.gz -C /tmp/ \
    && mkdir -p system \
    && cp -r /tmp/CodeIgniter-3.1.13/system/* system/ \
    && rm -rf /tmp/ci.tar.gz /tmp/CodeIgniter-3.1.13

# Copy application files
COPY . /var/www/html/

# Create session and cache directories with proper permissions
RUN mkdir -p /var/www/html/application/cache/sessions \
    && mkdir -p /var/www/html/application/logs

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/application/cache \
    && chmod -R 777 /var/www/html/application/logs

# Configure Apache for CodeIgniter
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/codeigniter.conf \
    && a2enconf codeigniter

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
