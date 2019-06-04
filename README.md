# 3D payment hosting merchant

<img src="https://lh3.googleusercontent.com/vvH_1F69Ki8FA1vDCbwb3GNMkiwPsBxagVB7mN95FEhd4otSlikbpCRbOY-a7d2UIw" width="50" height="50">
<img src="https://www.kgbus.rs/wp-content/uploads/thegem-logos/logo_9738e3a0c68a98d6688e95338d570ad3_1x.png">

Application for buying tickets integrated with Asseco 3D payment gateway.

### Prerequisites

Install git, docker and docker-compose on your server. Also your server needs to have access to WWW to download all required dependencies.

### Installing

Download project into selected directory, for example:

```
/var/www/html/ git clone https://github.com/atco89/3d-pay-hosting-merchant.git
```

Build docker images:

```
docker-compose build
```

Check are there two builded images by running following command:

```
docker images
```

Command above should return following output:

```
REPOSITORY                       TAG                 IMAGE ID            CREATED             SIZE
3dpayhostingmerchant_webserver   latest              3661f1ff2803        2 hours ago         440MB
3dpayhostingmerchant_database    latest              78c0c484003b        2 hours ago         389MB
php                              7.3.4-apache        1dffbbe4a5d3        4 weeks ago         378MB
mysql                            5.7.25              98455b9624a9        6 weeks ago         372MB
```

Run docker containers using -d (detached):

```
docker-compose up -d
```

Check status of containers:

```
docker ps -a
```

Command above should return following output:

```
CONTAINER ID        IMAGE                            COMMAND                  CREATED             STATUS              PORTS                               NAMES
6af85d4e6ec6        3dpayhostingmerchant_webserver   "docker-php-entrypoi…"   5 seconds ago       Up 4 seconds        0.0.0.0:8888->80/tcp                merchant_webserver
d2adeda4d139        3dpayhostingmerchant_database    "docker-entrypoint.s…"   6 seconds ago       Up 5 seconds        33060/tcp, 0.0.0.0:6603->3306/tcp   merchant_database
```

Enter into the web container:

```
docker exec -it "merchant_webserver" bash
```

Position yourself into the directory in which you've installed project. 
In our case it is /var/www/html/ and run command below which will install dependencies

```
composer install --no-dev --no-scripts
```

Open browser and start your application. You may found it listening on port 8888, while database is on 6603.

```
http://localhost:8888/public/
```

Code style is according to [PSR-2](https://www.php-fig.org/psr/psr-2/) standards.

## Built With

* [Docker](https://www.docker.com/) - Program that performs operating-system-level virtualization;
* [MySQL 5.7.25](https://dev.mysql.com/doc/relnotes/mysql/5.7/en/);
* [PHP 7.3.5](https://www.php.net/ChangeLog-7.php#7.3.5);
* [Composer](https://getcomposer.org/) - Dependency Manager for PHP;
* [Slim 3](http://www.slimframework.com/docs/) - PHP micro framework;
* [Eloquent](https://laravel.com/docs/5.8/eloquent) - Database ORM toolkit;
* [Guzzle](https://github.com/guzzle/guzzle) - PHP HTTP client library;
* [Respect Validation](https://github.com/Respect/Validation) - Validation engine for PHP;
* [Twig](https://twig.symfony.com/) - Template language for PHP;
* [Bootstrap 4](https://getbootstrap.com/) - Toolkit for developing with HTML, CSS, and JS;
* [jQuery](http://jquery.com/) - Fast, small, and feature-rich JavaScript library;
* [HTML 5](https://www.w3schools.com/html/html5_intro.asp).

## Author

* **Aleksandar Rakić** - *Initial work* - [www.aleksandarrakic.com](http://www.aleksandarrakic.com)

## License

This project is licensed under the MIT License - see the [LICENSE.md](documentation/license.md) file for details.