# Docker Deployment Guide for Input Penduduk Application

This guide provides instructions for deploying the Input Penduduk application using Docker with FrankenPHP and Laravel Octane.

## Prerequisites

- Docker Engine installed (version 20.10.0 or higher)
- Docker Compose installed (version 2.0.0 or higher)
- Git installed (to clone the repository)

## Deployment Steps

### 1. Clone the Repository

```bash
git clone <repository-url> input-pend
cd input-pend
```

### 2. Docker Setup Files

Create the following Docker files in your project root:

#### Dockerfile

Create a `Dockerfile` in the project root:

```dockerfile
FROM dunglas/frankenphp:latest-php8.2-alpine

# Install system dependencies
RUN apk add --no-cache \
    zip \
    unzip \
    curl \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    nodejs \
    npm

# Install PHP extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
    @composer \
    gd \
    intl \
    zip \
    pdo_mysql \
    pdo_sqlite \
    pcntl \
    opcache \
    mbstring \
    exif

# Copy application files
WORKDIR /app
COPY . /app
RUN chown -R root:root /app

# Configure PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-php.ini

# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
RUN npm install && npm run build

# Prepare Laravel application
RUN cp .env.example .env && \
    php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan storage:link

# Application will run on port 8000
EXPOSE 8000

# Start FrankenPHP with Octane
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]
```

#### docker-compose.yml

Create a `docker-compose.yml` file:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: input-penduduk-app
    ports:
      - "8000:8000"
    volumes:
      - ./storage:/app/storage
    depends_on:
      - db
    environment:
      DB_CONNECTION: mysql
      DB_HOST: db
      DB_PORT: 3306
      DB_DATABASE: ${DB_DATABASE:-input_penduduk}
      DB_USERNAME: ${DB_USERNAME:-input_user}
      DB_PASSWORD: ${DB_PASSWORD:-secure_password}
      APP_ENV: production
      APP_DEBUG: false
      OCTANE_SERVER: frankenphp
    restart: unless-stopped
    networks:
      - input-penduduk-network

  db:
    image: mysql:8.0
    container_name: input-penduduk-db
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: ${DB_DATABASE:-input_penduduk}
      MYSQL_USER: ${DB_USERNAME:-input_user}
      MYSQL_PASSWORD: ${DB_PASSWORD:-secure_password}
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD:-root_secure_password}
      SERVICE_NAME: mysql
    volumes:
      - db-data:/var/lib/mysql
      - ./docker/mysql/init:/docker-entrypoint-initdb.d
    restart: unless-stopped
    networks:
      - input-penduduk-network

volumes:
  db-data:

networks:
  input-penduduk-network:
    driver: bridge
```

#### PHP Configuration

Create a directory structure and configuration file:

```bash
mkdir -p docker/php
```

Create a PHP configuration file at `docker/php/php.ini`:

```ini
[PHP]
upload_max_filesize = 10M
post_max_size = 12M
memory_limit = 256M
max_execution_time = 120
date.timezone = UTC

opcache.enable=1
opcache.enable_cli=1
opcache.jit_buffer_size=100M
opcache.jit=1255

[opcache]
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.validate_timestamps=0
```

#### MySQL Initialization

Create a directory for MySQL initialization scripts:

```bash
mkdir -p docker/mysql/init
```

Create a SQL initialization file at `docker/mysql/init/01-import.sql`:

```sql
-- Import initial data from the SQL dump
SOURCE /docker-entrypoint-initdb.d/input-data-penduduk.sql;
```

Copy your SQL dump file to this directory:

```bash
cp input-data-penduduk.sql docker/mysql/init/
```

### 3. Laravel Octane Installation

Before deploying, you need to add Laravel Octane to your project. Add the following to your local development environment:

```bash
composer require laravel/octane
php artisan octane:install --server=frankenphp
```

This adds the necessary configuration to your Laravel project.

### 4. Environment Configuration

Create a `.env.docker` file in your project root:

```env
APP_NAME="Input Penduduk"
APP_ENV=production
APP_KEY=base64:your-application-key
APP_DEBUG=false
APP_URL=http://your-server-ip:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=input_penduduk
DB_USERNAME=input_user
DB_PASSWORD=secure_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

OCTANE_SERVER=frankenphp
```

### 5. Build and Run Docker Container

```bash
docker-compose build
docker-compose up -d
```

### 6. Run Database Migrations (First-Time Setup)

```bash
docker-compose exec app php artisan migrate --force
```

### 7. Verify Deployment

Access your application at http://your-server-ip:8000

## Maintenance Commands

### Restart Containers

```bash
docker-compose restart
```

### Update Application

```bash
# Pull latest code changes
git pull

# Rebuild and restart containers
docker-compose down
docker-compose build
docker-compose up -d

# Run migrations if needed
docker-compose exec app php artisan migrate --force
```

### View Logs

```bash
docker-compose logs -f app
```

## Scaling Considerations

For high-traffic implementations, consider the following:

1. Use a load balancer in front of multiple application containers
2. Separate the database to a dedicated host
3. Implement Redis for caching and session storage
4. Use a CDN for static assets

## Security Considerations

1. Keep Docker and all dependencies updated
2. Use secure passwords for all services
3. Restrict network access to your Docker host
4. Implement HTTPS using a reverse proxy like Nginx or Traefik
5. Follow the recommendations in the project's `SECURITY_POLICY.md`

## Troubleshooting

### Common Issues

1. **Connection refused to database**:
   - Wait a few seconds for MySQL to fully initialize
   - Check MySQL logs: `docker-compose logs db`

2. **Application errors**:
   - Check Laravel logs: `docker-compose exec app cat /app/storage/logs/laravel.log`
   - Ensure environment variables are correctly set

3. **Permission issues**:
   - Run `docker-compose exec app chown -R www-data:www-data /app/storage`
   - Make sure volumes are properly mounted

## Performance Tuning

FrankenPHP with Laravel Octane provides significant performance benefits:

1. Application state is persisted between requests
2. Reduced bootstrap time for each request
3. Efficient handling of concurrent requests

For best performance:
- Increase or decrease worker count based on server resources
- Monitor memory usage and adjust container limits as needed
- Consider implementing Redis for session storage

## Backup Strategy

1. Database:
   ```bash
   docker-compose exec db mysqldump -u input_user -p input_penduduk > backup_$(date +%Y%m%d).sql
   ```

2. Application files:
   ```bash
   docker-compose exec app tar -czf /app/storage/app/backup_$(date +%Y%m%d).tar.gz /app
   docker cp input-penduduk-app:/app/storage/app/backup_$(date +%Y%m%d).tar.gz ./
   ```

## Additional Resources

- [FrankenPHP Documentation](https://frankenphp.dev)
- [Laravel Octane Documentation](https://laravel.com/docs/10.x/octane)
- [Docker Documentation](https://docs.docker.com/)
