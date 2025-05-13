#!/bin/bash

# Stop and remove existing containers, networks, and volumes
docker-compose down --remove-orphans

# Build and start the containers
docker-compose up -d

# Install Symfony dependencies
docker-compose exec app composer install

# Create .env.dev for development-specific variables
# This overrides values in .env for development
cat > .env.dev << EOL
###> symfony/.env.dev ###
# Development environment overrides
APP_ENV=dev
APP_DEBUG=1

# Database connection
DATABASE_URL="mysql://symfony:symfony_password@db:3306/symfony?serverVersion=8.0&charset=utf8mb4"

# Development specific settings
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< symfony/.env.dev ###
EOL

# Copy the .env.local file into the container
docker-compose exec -T app bash -c "cat > /var/www/symfony/.env.dev" < .env.dev

# Set up database migrations
docker-compose exec app php bin/console doctrine:migrations:migrate --no-interaction

# Clear cache
docker-compose exec app php bin/console cache:clear

# Set proper permissions for cache and logs directories
docker-compose exec app chmod -R 777 var/cache var/log

# Generate JWT keys if the bundle is installed (uncomment if needed)
# docker-compose exec app mkdir -p config/jwt
# docker-compose exec app openssl genrsa -out config/jwt/private.pem 4096
# docker-compose exec app openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
# docker-compose exec app chmod 644 config/jwt/private.pem config/jwt/public.pem

echo "Your Symfony development environment is ready!"
echo "Web server: http://localhost:8000"
#echo "phpMyAdmin: http://localhost:8080"
echo "Note: Development-specific variables are stored in .env.dev"