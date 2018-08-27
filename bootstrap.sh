#!/usr/bin/env bash

SERVER_NAME=$1

hostname ${SERVER_NAME}
echo "$SERVER_NAME" > /etc/hostname

echo "# -- -- -- -- -- -- -- -- #"
echo "#  Update && upgrade Apt  #"
echo "# -- -- -- -- -- -- -- -- #"
apt-get update
apt-get upgrade -y


echo "# -- -- -- -- -- -- -- -- #"
echo "#  Install basics tools   #"
echo "# -- -- -- -- -- -- -- -- #"
apt-get install -y build-essential locate sshpass module-assistant
apt-get install -y apt-transport-https ca-certificates curl software-properties-common language-pack-fr


#echo "# -- -- -- -- -- -- -- -- #"
#echo "#  Install nginx /MariaDB #"
#echo "# -- -- -- -- -- -- -- -- #"
#apt-get install -y nginx mariadb-server

echo "# -- -- -- -- -- -- -- -- #"
echo "#  Install PHP & Composer #"
echo "# -- -- -- -- -- -- -- -- #"
add-apt-repository -y ppa:ondrej/php
apt-get update
apt-get install -y git php7.1 php7.1-fpm php7.1-mysql php7.1-curl php7.1-json php7.1-gd php7.1-mcrypt php7.1-msgpack php7.1-memcached php7.1-intl php7.1-sqlite3 php7.1-gmp php7.1-geoip php7.1-mbstring php7.1-redis php7.1-xml php7.1-zip

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

echo "# -- -- -- -- -- -- -- -- #"
echo "#  Install Magecoin #"
echo "# -- -- -- -- -- -- -- -- #"
cd /vagrant
su vagrant -c "php /home/vagrant/composer.phar install"
su vagrant -c "php /vagrant/bin/console server:run 0.0.0.0:8000 &"

echo "# -- -- -- -- -- -- -- -- #"
echo "#  Bootstrap.sh done !    #"
echo "# -- -- -- -- -- -- -- -- #"