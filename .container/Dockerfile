# Imagem Base Ubuntu 18.04
FROM ubuntu:18.04 as base_frontend_image

# Variaveis Ambiente
ENV SITE=homepage
ENV FOLDER=./.container

# Instalando pacotes bases do Ubuntu
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive
RUN apt-get install -y software-properties-common curl

# Configurar Timezone para America/Sao_Paulo
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Adicionando repositório PHP
RUN apt-get update && add-apt-repository ppa:ondrej/php

# Instalando Extensões do PHP
RUN apt-get update && \
    apt-get install -y --no-install-recommends \        
        php5.6 \
        php5.6-apcu \
        php5.6-bcmath \
        php5.6-calendar \
        php5.6-cli \
        php5.6-common \
        php5.6-curl \
        php5.6-dev \
        php5.6-gd \
        php5.6-intl \
        php5.6-json \
        php5.6-mbstring \
        php5.6-mysql \
        php5.6-mysqli \
        php5.6-opcache \
        php5.6-pgsql \
        php5.6-readline \
        php5.6-sqlite3 \
        php5.6-xml \
        php5.6-xmlwriter \
        php5.6-xmlreader \
        php5.6-zip \
        php5.6-redis \
        php5.6-soap \
        php5.6-pdo \
        php5.6-sockets \
        php5.6-ftp \
        php5.6-fpm \
        libapache2-mod-php5.6 \
        libpq-dev  

# Instalando Node
RUN curl -fsSL https://deb.nodesource.com/setup_13.x | bash - \
    && apt-get -y install --no-install-recommends \
    zlib1g-dev libzip-dev zip libpng-dev libicu-dev \
    wget gpg gpg-agent unzip libxml2-dev nodejs \
    && npm install --global yarn

# Instalando Apache Server
RUN apt update 
RUN apt install -y apache2 
RUN apt install -y apache2-utils 

# Instalando editor Nano
RUN apt-get update && \
    apt-get install -y nano

# Instalando GIT
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

# Azure App Service SSH Support
 RUN apt-get -y --no-install-recommends install \
    dialog openssh-server \
    && echo "root:Docker!" | chpasswd

# Limpando dados
RUN apt clean
RUN rm -rf /var/lib/apt/lists/*

###########################################################################################

FROM base_frontend_image as apache_frontend_image

# Permissão para alterar pastas
RUN chown -R www-data:www-data /var/www/

# Inserindo apache2.conf no container
COPY --chown=www-data:www-data $FOLDER/docker/create-site.sh /var/www/$SITE/

# Dando permissões ao Apache
RUN chown -R www-data:www-data /etc/apache2/sites-available
RUN chown -R www-data:www-data /etc/apache2/sites-enabled

# Inserindo apache2.conf no container
COPY --chown=www-data:www-data $FOLDER/docker/apache2.conf /etc/apache2/

# Habilitando apache modules
# Desabilitando mpm_prefork module
RUN service apache2 stop
RUN a2dismod php5.6
RUN a2dismod mpm_prefork

# Habilitando apache modules
RUN a2enmod deflate
RUN a2enmod headers
RUN a2enmod rewrite
RUN a2enmod mpm_event
RUN a2enmod http2
RUN a2enmod proxy
RUN a2enmod socache_shmcb.load

RUN apt update && apt install -y libapache2-mod-fcgid php5.6-fpm

RUN a2enmod proxy_fcgi
RUN a2enconf php5.6-fpm

RUN chown -R www-data:www-data /etc/php/5.6/fpm
COPY --chown=www-data:www-data $FOLDER/docker/fpm/ /etc/php/5.6/fpm/
COPY --chown=www-data:www-data $FOLDER/docker/php5.6-fpm.conf /etc/apache2/conf-available

# Permissao para rodar o script de criar httpd.conf
RUN chmod +x /var/www/$SITE/create-site.sh

# Script para criar o httpd.conf do apache2
RUN /bin/bash /var/www/$SITE/create-site.sh

###########################################################################################

FROM apache_frontend_image as project_frontend_image

# Pasta Raiz do Projeto
WORKDIR /var/www/$SITE/httpdocs

COPY --chown=www-data:www-data ./.container/docker/sshd_config /etc/ssh/

# Copiando Projeto para dentro do container e setando permissões
COPY --chown=www-data:www-data . .

# Permissao para rodar o script de criar httpd.conf
RUN chmod +x /var/www/$SITE/httpdocs/ENTRYPOINT.sh

# Permissão para alterar pastas
RUN chown -R www-data:www-data /var/www/$SITE/

RUN service php5.6-fpm stop
RUN service apache2 stop

EXPOSE 80 2222

#CMD ["/bin/bash", "-c", "/var/www/$SITE/httpdocs/ENTRYPOINT.sh"]
CMD ["/bin/bash", "-c", "set -e && service ssh start && service php5.6-fpm start && apachectl -DFOREGROUND"]