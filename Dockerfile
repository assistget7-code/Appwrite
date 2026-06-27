FROM php:8.2-apache

# Install cURL for Appwrite API calls
RUN apt-get update && apt-get install -y curl libcurl4-openssl-dev && docker-php-ext-install curl

# Copy project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/

EXPOSE 80
