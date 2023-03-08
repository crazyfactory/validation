# For why we separate so many docker layers by performing multiple RUN and COPY, please see
# https://docs.docker.com/develop/develop-images/dockerfile_best-practices/
# https://www.ginkgobioworks.com/2020/05/18/optimizing-your-dockerfile/

FROM base-php-fpm:php82 as base

COPY ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
RUN chmod 644 /usr/local/etc/php-fpm.d/www.conf

FROM base as composer-install

COPY --chown=www-data:www-data ./composer.json /var/www/project/composer.json
COPY --chown=www-data:www-data ./composer.lock /var/www/project/composer.lock

USER www-data
RUN COMPOSER_MEMORY_LIMIT=-1 composer install
USER root

FROM base as copy-volume

COPY --chown=www-data:www-data ./ /var/www/project


FROM base as env-file

RUN mkdir -p shop-env-config
RUN touch shop-env-config/.env

RUN chown www-data:www-data /var/www/project/shop-env-config/.env

# ---------------- CI ----------------- #

FROM base as image-ci-testing

# Travis should have the same ini setup as live prod
COPY ./docker/php/php-fpm-ini.ini /usr/local/etc/php/conf.d/999-overrides.ini

COPY --from=composer-install /var/www/project .
COPY --from=env-file /var/www/project .
COPY --from=copy-volume /var/www/project .

# Bind mount location
VOLUME ["/var/www/project"]

CMD php-fpm
