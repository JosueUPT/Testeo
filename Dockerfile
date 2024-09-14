# Usa una imagen base de PHP con Apache
FROM php:8.2-apache

# Copia el código fuente al directorio raíz del servidor web
COPY ./src /var/www/html/

# Instala las extensiones necesarias de PHP (como MySQLi)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Cambia permisos si es necesario
RUN chown -R www-data:www-data /var/www/html