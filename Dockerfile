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

# Instala Node.js e npm (opcional, se seu projeto usar)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia apenas os arquivos de dependência do Composer da subpasta 'php'
# Garanta que composer.lock exista ou ajuste para php/composer.json ./ se não usar lock no build inicial
COPY php/composer.json php/composer.lock* ./

# Instala dependências PHP
# Use --no-dev para produção, se aplicável
RUN composer install --no-interaction --no-scripts --prefer-dist

# Copia o restante dos arquivos da aplicação da subpasta 'php'
COPY php/. .

# Instala dependências JavaScript (opcional, se seu projeto usar e package.json estiver em php/)
# Se package.json não existir ou não for usado, você pode comentar ou remover a linha abaixo
RUN if [ -f package.json ]; then npm install; fi

# Permissão de pastas (importante para Laravel)
# Executa apenas se as pastas existirem para evitar erro no build inicial sem a estrutura completa
RUN if [ -d storage ]; then chmod -R 775 storage; fi
RUN if [ -d bootstrap/cache ]; then chmod -R 775 bootstrap/cache; fi

# Porta que o Laravel serve
EXPOSE 8000

# Comando padrão para iniciar o servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]