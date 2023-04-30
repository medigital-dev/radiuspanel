<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xls;

if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}
header('Content-Type: application/json; charset=utf-8');

require '../functions.php';
global $conn;

$temp_dir = '../temp/';
if (!file_exists($temp_dir)) {
    mkdir($temp_dir, 0777);
}

$target = basename($_FILES['file']['name']);
$path = $temp_dir . $target;
move_uploaded_file($_FILES['file']['tmp_name'], $path);

$reader = new Xls;
$activeSheet = $reader->load($path)->getActiveSheet();
$dataExcel = $activeSheet->toArray();
$berhasil = 0;

for ($i = 1; $i < count($dataExcel); $i++) {
    $username = $dataExcel[$i][0];
    $name = $dataExcel[$i][1];
    $division = $dataExcel[$i][2];
    $class = $dataExcel[$i][3];
    $registered = $dataExcel[$i][4];
    $password = $dataExcel[$i][5];

    if ($username != "" && $password != "") {
        $is_exist = query("SELECT * FROM radcheck WHERE username = '$username'");
        if (count($is_exist) == 0) {
            $query = "INSERT INTO radcheck VALUES (NULL, '$username', 'Cleartext-Password', ':=', '$password');";
            $query2 = "INSERT INTO organization VALUES (NULL, '$username', '$name', '$division', '$class', '$registered');";
            if (mysqli_query($conn, $query) && mysqli_query($conn, $query2)) {
                $berhasil++;
            }
        }
    }
}

$total = count($dataExcel) - 1;
unlink($path);
echo json_encode(['total' => $total, 'sukses' => $berhasil]);
