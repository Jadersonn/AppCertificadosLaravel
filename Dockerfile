FROM php:8.4-cli

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instala Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia arquivos (opcional, se quiser já na imagem)
COPY . .

# Instala dependências PHP (opcional na build, pode fazer manual)
RUN composer install

# Instala dependências JavaScript (opcional na build)
RUN npm install

# Permissão de pastas
RUN chmod -R 775 storage bootstrap/cache || true

# Porta que o Laravel serve
EXPOSE 8000

# Comando padrão
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
