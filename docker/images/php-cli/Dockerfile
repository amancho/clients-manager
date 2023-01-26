FROM php:cli-alpine

RUN apk add --update --no-cache oniguruma-dev libxml2-dev php-xml php-xmlreader php-xmlwriter
RUN docker-php-ext-install mbstring pdo

WORKDIR /var/www