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
# php extensions.
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
# install composer.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer
# make port 80 available to the world outside this container.
EXPOSE 80
