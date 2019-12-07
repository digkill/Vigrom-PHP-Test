FROM ubuntu:18.04

ENV DEBIAN_FRONTEND noninteractive

COPY image-files/ /

RUN apt-get update && apt-get install -yq \
    cron \
    telnet \
    curl \
    apt-utils \
    mc \
    git \
    apache2 \
    libapache2-mod-php7.2 \
    php-ssh2 \
    php7.2-bcmath \
    php7.2-cli \
    php7.2-json \
    php7.2-curl \
    php7.2-fpm \
    php7.2-gd \
    php7.2-mbstring \
    php7.2-pgsql \
    php7.2-mysql \
    php7.2-soap \
    php7.2-sqlite3 \
    php7.2-xml \
    php7.2-zip \
    php7.2-intl \
    php-imagick \
    php-pear \
    graphicsmagick \
    imagemagick \
    iputils-ping \
    locales \
    && curl -sL https://deb.nodesource.com/setup_10.x | ln -s - \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && locale-gen en_US.UTF-8 en_GB.UTF-8 de_DE.UTF-8 es_ES.UTF-8 fr_FR.UTF-8 it_IT.UTF-8 km_KH sv_SE.UTF-8 fi_FI.UTF-8 \
    && a2enmod rewrite expires

EXPOSE 80 443

WORKDIR /var/www/html



