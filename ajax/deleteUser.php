<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

header('Content-Type: application/json; charset=utf-8');

require "../functions.php";
global $conn;

$username = $_POST['username'];
$query = "DELETE FROM radcheck WHERE username = '$username';";
$query .= "DELETE FROM organization WHERE username = '$username';";

if (!mysqli_multi_query($conn, $query)) {
    echo false;
    die;
}

echo true;
