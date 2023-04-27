#!/bin/bash
clear
G='\e[32m'
R='\033[01;31m'
W='\e[39m'
if [[ $EUID -ne 0 ]]; then
  echo -e "$RError! Gunakan user root$W" 
exit 0 
fi

response=`curl -s https://api.github.com/repos/medigital-dev/radiuspanel/releases/latest`
version=`echo $response | cut -d ',' -f 26 | cut -d '"' -f 4`
url=`echo $response | cut -d ',' -f 62 | cut -d '"' -f 4`

echo -e "UPDATE RadiusPanel TO v$version"
cd /tmp
wget $url

if [ -f /usr/share/radiuspanel/dbconn.php ]; then
    mv /usr/share/radiuspanel/dbconn.php /tmp
fi

rm -rf /usr/share/radiuspanel/*
tar zxvf /tmp/radiuspanel.tar.gz -C /usr/share/radiuspanel/

if [ -f /tmp/dbconn.php ]; then
    mv /tmp/dbconn.php /usr/share/radiuspanel/
fi

chmod -R 777 /usr/share/radiuspanel/
chown -R www-data.www-data /usr/share/radiuspanel

if [ -f /usr/share/radiuspanel/database/update.sql ]; then
    mysql -uroot -pradpass radius < /usr/share/radiuspanel/database/update.sql
fi

echo -e "UPDATE DONE"