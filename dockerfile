# Use the official PHP image
FROM php:8.0-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . .

# Install any necessary PHP extensions (optional)
RUN docker-php-ext-install

# Expose port 80
EXPOSE 80

# Command to run when starting the container
CMD ["apache2-foreground"]
