<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

exec('bash update.sh');
echo true;
