<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/medigital-dev/radiuspanel/releases/latest');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$output = json_decode(curl_exec($ch), true);
curl_close($ch);

$url = $output['assets'][0]['browser_download_url'];
$filename = 'radiuspanel.tar.gz';
$path = '../temp/' . $filename;
if (file_put_contents($path, file_get_contents($url), FILE_APPEND)) {
    shell_exec(`mv /usr/share/radiuspanel/temp/radiuspanel.tar.gz /tmp`);
    shell_exec(`mv /usr/share/radiuspanel/dbconn.php /tmp`);
    shell_exec(`rm -rf /usr/share/radiuspanel/*`);
    shell_exec(`tar zxf /tmp/radiuspanel.tar.gz -C /usr/share/radiuspanel/`);
    shell_exec(`mv /tmp/dbconn.php /usr/share/radiuspanel/`);
    shell_exec(`rm -rf /tmp/radiuspanel.tar.gz`);
    shell_exec(`chmod -R 777 /usr/share/radiuspanel/`);
    shell_exec(`chown -R www-data.www-data /usr/share/radiuspanel`);
} else {
    die(false);
}

echo true;
