FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Node.js and npm (for WebSocket server)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install WebSocket dependencies
WORKDIR /var/www/html
COPY package.json /var/www/html
RUN npm install

RUN a2enmod rewrite
RUN a2enmod headers

# Copy application source
COPY . /var/www/html/

EXPOSE 80
EXPOSE 8080

# Start both Apache and WebSocket server
CMD service apache2 start && node /var/www/html/server.js
