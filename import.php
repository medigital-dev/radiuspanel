<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

require('functions.php');
require('spreadsheet-reader/php-excel-reader/excel_reader2.php');
require('spreadsheet-reader/SpreadsheetReader.php');

global $conn;

$temp_dir = 'temp/';
if (!file_exists($temp_dir)) {
    mkdir($temp_dir, 0777);
}

$target = basename($_FILES['file']['name']);
$path = $temp_dir . $target;
move_uploaded_file($_FILES['file']['tmp_name'], $path);

$reader = new SpreadsheetReader($path);
$s = $t = 0;

foreach ($reader as $row) {
    if ($t > 0) {
        $username = $row[0];
        $name = str_replace("'", "", $row[1]);
        $division = $row[2];
        $class = $row[3];
        $registered_at = $row[4];
        $password = $row[5];

        if (!query("SELECT * FROM radcheck WHERE username = '$username'")) {
            $queri = "INSERT INTO radcheck VALUES (NULL, '$username', 'Cleartext-Password', ':=', '$password');";
            $queri2 = "INSERT INTO organization VALUE (null,'$username','$name','$division','$class','$registered_at');";
            if (mysqli_query($conn, $queri) && mysqli_query($conn, $queri2)) {
                $s++;
            } else {
                echo "<pre>";
                var_dump(mysqli_error($conn));
                echo "</pre>";
                die;
            }
        }
    }
    $t++;
}
unlink($path);
header('Location: users.php?t=' . $t . '&s=' . $s);
