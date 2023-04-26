<?php
$url = $_POST['assets'][0]['browser_download_url'];

shell_exec('cd /tmp');
shell_exec('wget ' . $url);
shell_exec('tar -zxvf update.tar.gz');
shell_exec('mv radiuspanel /usr/share/');
shell_exec('chmod -R 777 /usr/share/radiuspanel/');
shell_exec('chown -R www-data.www-data /usr/share/radiuspanel');

echo true;
