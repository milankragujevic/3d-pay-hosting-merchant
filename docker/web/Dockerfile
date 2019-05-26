FROM php:7.3.5-apache
# set maintainer.
MAINTAINER Aleksandar Rakić <info@aleksandarrakic.com>
# copy the files from root to container.
COPY /src /var/www/html
# set the working directory in container.
WORKDIR /var/www/html
# install linux packages.
RUN apt-get install
RUN apt-get update
RUN apt-get install libzip-dev -y
RUN apt-get install zlib1g-dev -y
RUN apt-get install unzip -y
RUN apt-get install openssl -y
# php extensions.
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
# install composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN openssl req -new -newkey rsa:4096 -days 3650 -nodes -x509 -subj \
        "/C=SR/ST=Serbia/L=Belgrade/O=Apex Solution Technology/CN=Apex" \
        -keyout ./ssl.key -out ./ssl.crt
# copy certificates
COPY ./docker/web/certs/STAR_busplus_rs.crt /etc/apache2/ssl/ssl.crt
COPY ./docker/web/certs/STAR_busplus_rs.key /etc/apache2/ssl/ssl.key
RUN mkdir -p /var/run/apache2/
# enable ssl
RUN a2enmod rewrite
RUN a2enmod ssl
RUN service apache2 restart
# make port 80 and 443 available to the world outside this container.
EXPOSE 80
EXPOSE 443