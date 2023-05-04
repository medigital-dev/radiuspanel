### Installing Web-Server on debian 11

apt update
apt install lsb-release apt-transport-https ca-certificates software-properties-common wget sudo -y
wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
apt update

wget https://dev.mysql.com/get/mysql-apt-config_0.8.22-1_all.deb
sudo apt install ./mysql-apt-config_0.8.22-1_all.deb

apt update
apt install apache2 mysql-server php php-mysql curl php-cli php-mbstring git unzip php-zip php-curl php-xml php-gd php-fpm

add-apt-repository ppa:ondrej/php

apt install php8.0 php8.0-cli php8.0-mbstring php8.0-mysql php8.0-zip php8.0-curl php8.0-xml php8.0-gd libapache2-mod-php8.0 php-common php8.0-common php8.0-opcache php8.0-readline php-pear
