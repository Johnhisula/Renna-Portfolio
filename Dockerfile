FROM php:8.3-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory to Apache web root
WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html/

# Make sure logs directory exists and is writable
RUN mkdir -p /var/www/html/logs \
    && chmod -R 775 /var/www/html/logs \
    && chown -R www-data:www-data /var/www/html

# Configure Apache to allow .htaccess overrides
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/project.conf \
    && a2enconf project

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
