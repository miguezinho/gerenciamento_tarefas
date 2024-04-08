FROM php:8.2

# Extensões e módulos necessários do PHP
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-install zip
RUN apt-get update && \
    apt-get install -y zlib1g-dev libpng-dev libjpeg-dev
RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd

# Definindo diretório de trabalho e cópia dos códigos fontes para a imagem
WORKDIR /var/www/html
COPY . ./

# Composer para instalação das dependências do PHP
COPY --from=composer:2.7.2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer clear-cache
RUN composer install 

# Node para instalação dos pacotes npm
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install