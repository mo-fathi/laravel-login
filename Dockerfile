FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install dependencies
RUN apt-get update \
	&& apt-get install -y --no-install-recommends \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libzip-dev \
		libxml2-dev \
		libonig-dev \
		libgmp-dev \
		locales \
		zlib1g-dev \
		git \
		curl \
		nano \
		unzip \
		jpegoptim \
		optipng \
		pngquant \
		gifsicle 

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd bcmath pdo_mysql mbstring pdo gmp zip opcache 

# Clear apt cache	
RUN apt-get clean \
	&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* 

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set Working directory
WORKDIR /var/www

USER $user

# copy project
COPY . .

# Install project dependencies
RUN composer install --ignore-platform-reqs --optimize-autoloader --no-dev

# Expose PHP-FPM port and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]
