FROM php:8.3-fpm

WORKDIR /home
RUN apt-get update
RUN apt-get install -y curl

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer

RUN apt-get install -y zlib1g-dev && apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN composer global require laravel/installer
RUN ["/bin/bash", "-c", "echo PATH=$PATH:~/.composer/vendor/bin/ >> ~/.bashrc"]
RUN ["/bin/bash", "-c", "source ~/.bashrc"]

RUN mkdir -p /home/admin-blog/storage && \
    mkdir -p /home/admin-blog/bootstrap/cache

RUN chown -R $USER:www-data /home/admin-blog/storage
RUN chown -R $USER:www-data /home/admin-blog/bootstrap/cache
RUN chmod 775 -R /home/admin-blog/bootstrap/cache
RUN chmod 775 -R /home/admin-blog/storage

EXPOSE 9000 80 443
CMD ["php-fpm"]
