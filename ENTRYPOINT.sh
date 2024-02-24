#!/bin/bash

#Inserir variaveis ambientes dentro dos scripts .sh
envsubst < /var/www/homepage/create-site.sh
envsubst < /var/www/homepage/httpdocs/sitemap.xml
envsubst < /etc/apache2/apache2.conf

bash /var/www/homepage/create-site.sh

service php5.6-fpm start

apachectl -DFOREGROUND

