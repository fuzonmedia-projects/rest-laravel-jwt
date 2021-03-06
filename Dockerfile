FROM php:7.4-apache

USER root

# Copy composer.lock and composer.json
COPY ./composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    locales \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    librdkafka-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl

# GD library
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd

#install redis 
RUN pecl install igbinary
RUN pecl install redis && docker-php-ext-enable redis
# install kafka connection
RUN cd /tmp \
  && git clone --branch v1.5.0 --depth 1 https://github.com/edenhill/librdkafka.git \
  && cd librdkafka \
  && ./configure \
  && make \
  && make install \
  && pecl install rdkafka \
  && docker-php-ext-enable rdkafka \
  && rm -rf /tmp/librdkafka 


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY ./ /var/www/html

# Copy existing application directory permissions
COPY --chown=www:www ./app/ /var/www/html


ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite
#RUN service apache2 restart

# Change current user to www
#USER www

# Install packages 
RUN cd /var/www/html/ && composer install 
    
# Expose port 80 and start apache server
EXPOSE 80
EXPOSE 3036
CMD ["apache2-foreground"]