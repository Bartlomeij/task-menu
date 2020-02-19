FROM ubuntu:18.04
MAINTAINER Bart Rozycki "bartlomiej@rozycki.waw.pl"

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update
RUN apt-get -y install net-tools nginx software-properties-common curl supervisor
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt-get -y install php7.4-fpm
RUN apt-get -y install php7.4-mbstring
RUN apt-get -y install php7.4-xml
RUN apt-get -y install php7.4-curl
RUN apt-get -y install php7.4-mysql
RUN apt-get -y install git unzip


COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/nginx-php-fpm.conf

RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
	ln -sf /dev/stderr /var/log/nginx/error.log

RUN mkdir /run/php && chown www-data /run/php
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"  && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

RUN apt-get update
RUN apt-get install -y php7.4-dev php-pear && \
    pecl install xdebug && \
    echo "zend_extension=/usr/lib/php/20180731/xdebug.so" > /etc/php/7.4/fpm/conf.d/xdebug.ini && \
    echo "xdebug.default_enable=1" >> /etc/php/7.4/fpm/conf.d/xdebug.ini && \
    echo "xdebug.remote_enable=1" >> /etc/php/7.4/fpm/conf.d/xdebug.ini && \
    echo "xdebug.remote_autostart=1" >> /etc/php/7.4/fpm/conf.d/xdebug.ini && \
    echo "xdebug.remote_connect_back=0" >> /etc/php/7.4/fpm/conf.d/xdebug.ini && \
    echo "xdebug.remote_handler=dbgp" >> /etc/php/7.4/fpm/conf.d/xdebug.ini && \
    echo "xdebug.remote_port=9000" >> /etc/php/7.4/fpm/conf.d/xdebug.ini && \
    echo "xdebug.remote_host=docker.for.mac.host.internal" >> /etc/php/7.4/fpm/conf.d/xdebug.ini

RUN pecl install redis
RUN echo "extension=redis.so" > /etc/php/7.4/mods-available/redis.ini && \
    ln -sf /etc/php/7.4/mods-available/redis.ini /etc/php/7.4/fpm/conf.d/20-redis.ini && \
    ln -sf /etc/php/7.4/mods-available/redis.ini

ENTRYPOINT sh /root/.docker/start.sh

WORKDIR /application

EXPOSE 80
EXPOSE 443

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/nginx-php-fpm.conf"]

