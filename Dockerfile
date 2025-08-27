FROM dunglas/frankenphp:php8.3

COPY . /app/public

RUN install-php-extensions \
	pdo_mysql \
	gd \
	intl \
	zip \
	opcache