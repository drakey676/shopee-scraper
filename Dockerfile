# Gunakan image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Salin semua file dari repo ke dalam folder web server
COPY . /var/www/html/

# Buka port 80 (port default Apache)
EXPOSE 80
