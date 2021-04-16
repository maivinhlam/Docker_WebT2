FROM ubuntu:18.04


ARG TZ=Asia/Tokyo
ARG USER_ID=501
ARG GROUP_ID=20
ENV USER_ID ${USER_ID}
ENV GROUP_ID ${GROUP_ID}

ENV TERM=xterm \
    TZ=Asia/Tokyo \
    DEBIAN_FRONTEND=noninteractive


RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update --fix-missing  && \
    apt-get install -y software-properties-common

RUN add-apt-repository ppa:ondrej/php
RUN apt-get update

# Install apps mysql-server
RUN apt-get -y install python3-pip  supervisor nginx curl git cron  zip unzip curl wget  \
    php7.3-fpm php7.3-mbstring php7.3-xmlrpc php7.3-soap php7.3-gd php7.3-xml php7.3-cli php7.3-zip php7.3-mysql php7.3-bcmath php7.3-curl php7.3-intl \
    php5.6-fpm php5.6-mbstring \
    php5.6-xmlrpc php5.6-soap php5.6-gd php5.6-xml \
    php5.6-cli php5.6-zip php5.6-mysql php5.6-bcmath php5.6-curl php5.6-intl

# Python package
RUN export LC_ALL=C.UTF-8
RUN pip3 install eng-to-ipa

# PHP-FPM
RUN mkdir /run/php
COPY php-fpm/7.3/www.conf /etc/php/7.3/fpm/pool.d/www.conf
COPY php-fpm/7.3/php.ini /etc/php/7.3/fpm/php.ini

COPY php-fpm/5.6/www.conf /etc/php/5.6/fpm/pool.d/www.conf
COPY php-fpm/5.6/php.ini /etc/php/5.6/fpm/php.ini

#  Nginx
RUN mkdir -p /var/www/html && echo "<?php phpinfo();" > /var/www/html/index.php
COPY nginx/nginx.conf /etc/nginx/nginx.conf
RUN rm /etc/nginx/sites-enabled/default
COPY nginx/sites /etc/nginx/sites-enabled

# Cronjob
COPY cron/laravel /etc/cron.d/laravel
RUN chmod 0644 /etc/cron.d/laravel
RUN crontab /etc/cron.d/laravel

# Supervisor
COPY supervisor/supervisord.conf /etc/supervisor/supervisord.conf


# User
RUN groupadd -f -g ${GROUP_ID} tdins && useradd -r -s /bin/sh -g ${GROUP_ID} -u ${USER_ID} tdins
#Add user to www-data group
RUN usermod -a -G tdins www-data

# Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Adminer
RUN mkdir /usr/share/adminer
RUN wget "http://www.adminer.org/latest.php" -O /usr/share/adminer/index.php

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog


COPY ./docker-run.sh /docker-run.sh

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]


EXPOSE 80 443 6379 3306