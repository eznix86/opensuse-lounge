FROM node:22-alpine AS assets-builder

WORKDIR /assets

COPY package.json package-lock.json* ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

FROM composer:2 AS php-builder

WORKDIR /backend

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .

FROM serversideup/php:8.5-frankenphp

WORKDIR /var/www/html/

COPY --from=php-builder /backend/app ./app
COPY --from=php-builder /backend/bootstrap ./bootstrap
COPY --from=php-builder /backend/config ./config
COPY --from=php-builder /backend/database ./database
COPY --from=php-builder /backend/public ./public
COPY --from=php-builder /backend/resources ./resources
COPY --from=php-builder /backend/routes ./routes
COPY --from=php-builder /backend/storage ./storage
COPY --from=php-builder /backend/vendor ./vendor
COPY --from=php-builder /backend/artisan ./artisan
COPY --from=php-builder /backend/composer.json ./composer.json

COPY --from=assets-builder /assets/public/build ./public/build

COPY --chmod=755 entrypoint.sh ./entrypoint.sh

USER root
RUN chown -R www-data:www-data /var/www/html
USER www-data

HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 CMD [ "healthcheck-octane" ]

ENTRYPOINT [ "sh", "entrypoint.sh" ]
