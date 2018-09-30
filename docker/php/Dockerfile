FROM phpdockerio/php72-fpm:latest

ENV TERM xterm
ENV PHP_IDE_CONFIG serverName=editor

RUN apt-get update \
    && apt-get -y --no-install-recommends install  php-memcached php7.2-mysql php-redis php7.2-dev php7.2-sqlite3 php7.2-bcmath php7.2-soap php7.2-bz2 php7.2-gd php-imagick php7.2-intl php7.2-mbstring php7.2-xsl php7.2-tidy php7.2-xmlrpc php-yaml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

#####################################
# xDebug:
#####################################

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    # Install the xdebug extension
    apt-get update \
        && apt-get -y --no-install-recommends install php-xdebug \
        && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
;fi

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

WORKDIR "/var/www/editor"