FROM php:8.3-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . /var/www/html/

# Make logs directory writable
RUN mkdir -p /var/www/html/logs \
    && chmod -R 775 /var/www/html/logs \
    && chown -R www-data:www-data /var/www/html

# Allow .htaccess overrides
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/project.conf \
    && a2enconf project

# Create startup script — Railway injects $PORT dynamically
RUN printf '#!/bin/bash\n\
PORT="${PORT:-80}"\n\
sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf\n\
sed -i "s/<VirtualHost \\*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-enabled/000-default.conf\n\
exec apache2-foreground\n' > /start.sh \
    && chmod +x /start.sh

EXPOSE 80

CMD ["/bin/bash", "/start.sh"]
