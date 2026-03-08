# Desarrollo web en Entorno Servidor
# Entorno de desarrollo para Laravel (Sin Sail)
# Usamos PHP 8.4 CLI
FROM php:8.4-cli

# Definimos el usuario y los permisos
ARG USERNAME=admin
ARG USER_ID=1000
ARG GROUP_ID=1000

# Definimos la ruta al home del usuario
ENV HOME=/home/$USERNAME

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Instalamos las dependencias básicas + herramientas
RUN apt-get update && apt-get install -y \
    curl git unzip zip gnupg2 lsb-release \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev libxml2-dev libicu-dev \
    nano sudo \
    && rm -rf /var/lib/apt/lists/*

# Instalamos Node.js 22.x (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Instalamos extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql mbstring exif pcntl bcmath gd intl zip xml

# Instalamos composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Creamos el usuario y configuramos los permisos
RUN groupadd -g $GROUP_ID $USERNAME \
    && useradd -u $USER_ID -g $GROUP_ID -m -s /bin/bash $USERNAME \
    && echo "$USERNAME ALL=(ALL) NOPASSWD:ALL" > \
    /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

RUN chown -R $USERNAME:$USERNAME /home/$USERNAME

# ✅ AÑADIR ESTA LÍNEA:
RUN chown -R $USERNAME:$USERNAME /var/www/html

# Establecemos el usuario
USER $USERNAME