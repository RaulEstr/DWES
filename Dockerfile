
FROM php:8.2-apache

# Dependencias necesarias para las extensiones PHP
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        mysqli \
        pdo \
        pdo_mysql \
        intl \
        gd \
        zip \
    && rm -rf /var/lib/apt/lists/*

# Activar mod_rewrite para CodeIgniter
RUN a2enmod rewrite

# Instalar Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Mantener como DocumentRoot la raíz de htdocs
ENV APACHE_DOCUMENT_ROOT=/var/www/html

# Permitir el uso de .htaccess
RUN printf '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html
