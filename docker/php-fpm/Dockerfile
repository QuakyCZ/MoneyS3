FROM phpdockerio/php:8.3-fpm

ARG HOST_UID
ARG HOST_GID

# Vytvoření skupiny a uživatele
RUN groupadd -g $HOST_GID appgroup \
    && useradd -u $HOST_UID -g appgroup -m appuser

# Nastavení vlastnictví PHP-FPM procesů
RUN sed -i "s/user = www-data/user = appuser/" /etc/php/8.3/fpm/pool.d/www.conf \
    && sed -i "s/group = www-data/group = appgroup/" /etc/php/8.3/fpm/pool.d/www.conf

RUN chmod 777 /tmp -R


COPY fpm-pool.conf /etc/php/8.3/fpm/pool.d/www.conf


WORKDIR "/application"

RUN apt-get update; \
    apt-get -y --no-install-recommends install

EXPOSE 9000