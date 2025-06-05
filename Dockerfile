# Gunakan image PHP + Apache
FROM php:8.2-apache

# Copy semua file ke folder web Apache
COPY . /var/www/html/

# Ubah Apache supaya dengar di port 8080 (bukan default 80)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# Ekspos port 8080
EXPOSE 8080
