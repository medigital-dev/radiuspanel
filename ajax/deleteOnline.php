<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

header('Content-Type: application/json; charset=utf-8');

require "../functions.php";
global $conn;

$query = "TRUNCATE TABLE radacct";

if (!mysqli_query($conn, $query)) {
    echo false;
    die;
}

echo json_encode(mysqli_affected_rows($conn));
