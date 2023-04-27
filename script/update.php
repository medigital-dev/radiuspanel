<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    exec('bash update.sh');
    echo true;
} else {
    echo 'Akses ditolak!';
    die;
}
