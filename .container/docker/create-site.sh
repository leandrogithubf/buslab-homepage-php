#!/bin/bash

if [ "$(id -u)" != "0" ]; then
  echo "Rode o script com sudo" 2>&1
  exit 1
fi

SITE="homepage"
DOMINIO_CONF="httpd.conf"
HOST_NAME="buslab.com.br"

if [ -f "/etc/apache2/sites-available/${DOMINIO_CONF}" ]; then
  echo "já existe um arquivo de configuração do site, abortando instalação" 2>&1
  exit 1
fi

touch /etc/apache2/sites-available/$DOMINIO_CONF

touch /etc/apache2/sites-available/$DOMINIO_CONF

echo "UseCanonicalName On" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo ""  >> /etc/apache2/sites-available/$DOMINIO_CONF

echo "<VirtualHost *:80>" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "        Protocols h2 http/1.1" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "" >> /etc/apache2/sites-available/$DOMINIO_CONF

echo "        ServerName buslab.com.br" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "        ServerAlias www.buslab.com.br" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "" >> /etc/apache2/sites-available/$DOMINIO_CONF

echo "        DocumentRoot /var/www/${SITE}/httpdocs" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "" >> /etc/apache2/sites-available/$DOMINIO_CONF

echo "        <IfModule mod_deflate.c>" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                AddOutputFilterByType DEFLATE text/html text/plain text/css application/javascript application/x-javascript" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "        </IfModule>" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "" >> /etc/apache2/sites-available/$DOMINIO_CONF

echo "        <IfModule mod_expires.c>" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresActive On" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresDefault \"access plus 1 day\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType text/html \"access plus 600 seconds\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType image/gif \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType image/jpg \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType image/jpeg \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType image/png \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType image/ico \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType image/x-icon \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType text/js \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType text/css \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType text/javascript \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "                ExpiresByType application/javascript \"access plus 1 year\"" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "        </IfModule>" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "" >> /etc/apache2/sites-available/$DOMINIO_CONF

echo "        ServerAdmin server@topnode.com.br" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "        ErrorLog /var/www/${SITE}/logs/error.log" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "        CustomLog /var/www/${SITE}/logs/access.log combined" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "" >> /etc/apache2/sites-available/$DOMINIO_CONF


echo " RewriteEngine on" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo " RewriteCond %{SERVER_NAME} =buslab.com.br [OR]" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo " RewriteCond %{SERVER_NAME} =www.buslab.com.br" >> /etc/apache2/sites-available/$DOMINIO_CONF
#echo " RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]" >> /etc/apache2/sites-available/$DOMINIO_CONF
#echo " RewriteCond %{SERVER_NAME} =$SITE" >> /etc/apache2/sites-available/$DOMINIO_CONF
echo "</VirtualHost>" >> /etc/apache2/sites-available/$DOMINIO_CONF

mkdir -p /var/www/$SITE/httpdocs
mkdir /var/www/$SITE/logs
touch /var/www/$SITE/logs/error.log
touch /var/www/$SITE/logs/access.log
chown -R www-data:www-data /var/www/$SITE/httpdocs
chown -R www-data:www-data /var/www/$SITE/logs
chmod -R 775 /var/www/$SITE/httpdocs

a2ensite $DOMINIO_CONF
#service apache2 reload

chown -R www-data:www-data /var/www/$SITE/httpdocs/

touch /etc/logrotate.d/$SITE
echo "/var/www/${SITE}/logs/*.log {" > /etc/logrotate.d/$SITE
echo "    daily" >> /etc/logrotate.d/$SITE
echo "    rotate 5" >> /etc/logrotate.d/$SITE
echo "    compress" >> /etc/logrotate.d/$SITE
echo "    create" >> /etc/logrotate.d/$SITE
echo "    delaycompress" >> /etc/logrotate.d/$SITE
echo "    size 1M" >> /etc/logrotate.d/$SITE
echo "    notifempty" >> /etc/logrotate.d/$SITE
echo "    nomail" >> /etc/logrotate.d/$SITE
echo "    missingok" >> /etc/logrotate.d/$SITE
echo "    noolddir" >> /etc/logrotate.d/$SITE
echo "}" >> /etc/logrotate.d/$SITE