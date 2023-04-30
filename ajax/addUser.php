<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

header('Content-Type: application/json; charset=utf-8');

require "../functions.php";
global $conn;

$data = $_POST['dataAccount'];
$username = htmlspecialchars($data["username"]);
$name = htmlspecialchars($data["name"]);
$division = htmlspecialchars($data["division"]);
$date = date('Y-m-d', time());
$password = htmlspecialchars($data["password"]);

if (query("SELECT * FROM radcheck WHERE username = '$username'")) {
    $response = [
        'status' => false,
        'message' => 'Username sudah ada!'
    ];
    echo json_encode($response);
    die;
}

$query = "INSERT INTO radcheck VALUES (NULL, '$username', 'Cleartext-Password', ':=', '$password');";
$query .= "INSERT INTO organization VALUES (NULL, '$username', '$name', '$division', NULL, '$date')";

if (!mysqli_multi_query($conn, $query)) {
    $response = [
        'status' => false,
        'message' => mysqli_error($conn)
    ];
    echo json_encode($response);
    die;
}

$response = [
    'status' => true,
    'message' => 'Data user berhasil ditambahkan!'
];

echo json_encode($response);
