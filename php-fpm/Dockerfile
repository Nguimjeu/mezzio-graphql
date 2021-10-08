FROM php:8-fpm

ARG uid
ARG user
ARG password

RUN apt-get update && apt-get install -y \
    apt-utils \
    git \
    bash-completion \
    build-essential \
    debconf-utils \
    debconf \
    sudo \
    default-mysql-client \
    curl \
    wget \
    nano \
    vim \
    zip \
    unzip \
    zlib1g-dev\
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    apt-transport-https \
    lsb-release \
    ca-certificates \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install zip mysqli pdo_mysql gd soap opcache \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run commands like composer
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && echo "${user} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

RUN { \
        echo "alias lt='ls --human-readable --size -1 -S --classify'"; \
        echo "alias ll='ls --color=auto -alF'"; \
        echo "alias la='ls --color=auto -alF'"; \
        echo "alias l='ls --color=auto -CF'"; \
        echo "alias grep='grep --color=auto'"; \
        echo "alias egrep='egrep --color=auto'"; \
        echo "alias fgrep='fgrep --color=auto'"; \
        echo "alias df='df -H'"; \
        echo "alias du='du -ch'"; \
        echo "alias cpv='rsync -ah --info=progress2'"; \
        echo "alias tailf='tail -f'"; \
        echo ""; \
    } >> /etc/bash.bashrc

USER $user