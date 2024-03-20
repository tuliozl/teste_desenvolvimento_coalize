FROM webdevops/php-apache:7.1-alpine
WORKDIR "/app"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php7.1-bcmath \ 
        php7.1-bz2 \ 
        php7.1-gd \ 
        php7.1-imagick \ 
        php7.1-memcached \ 
        php7.1-mysql \ 
        php7.1-redis \ 
        php7.1-tidy \
        php7.1-mbstring; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*