FROM php:7.3.5-apache

# set maintainer.
MAINTAINER Aleksandar Rakić <info@aleksandarrakic.com>

# install linux packages.
RUN apt-get update
RUN apt-get install libzip-dev -y
RUN apt-get install zlib1g-dev -y
RUN apt-get install unzip -y

# copy certificates.
COPY ./docker/web/certs/STAR_busplus_rs.crt /etc/apache2/ssl/server.crt
COPY ./docker/web/certs/STAR_busplus_rs.key /etc/apache2/ssl/server.key
COPY ./docker/web/dev.conf /etc/apache2/sites-enabled/dev.conf

# php extensions.
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

# enable ssl.
RUN a2enmod rewrite
RUN a2enmod ssl
RUN service apache2 restart

# copy the files from root to container.
COPY ./src/ /var/www/html/

# set the working directory in container.
WORKDIR /var/www/html

# install composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

# enable ssl.
RUN a2enmod rewrite
RUN a2enmod ssl
RUN service apache2 restart

RUN mkdir 777 /var/www/html/logs

# make port 443 available to the world outside this container.
EXPOSE 443