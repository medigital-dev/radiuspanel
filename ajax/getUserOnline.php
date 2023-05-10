<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

header('Content-Type: application/json; charset=utf-8');

require "../functions.php";
global $conn;

$online = query("SELECT * FROM radacct LEFT JOIN organization ON radacct.username = organization.username ORDER BY radacct.acctstarttime DESC");

$data = [];
$i = 1;

foreach ($online as $row) {
    $username = $row["username"];
    $detik = $row["acctsessiontime"];
    $jam = floor($row["acctsessiontime"] / 3600);
    $sisaJam = $detik - ($jam * 3600);
    $menit = floor($sisaJam / 60);
    $sisaMenit = $sisaJam - ($menit * 60);
    $sisaDetik = $detik - ($jam * 3600) - ($menit * 60);
    $upJam = ($jam == "0") ? "" : "$jam jam";
    $upMenit = ($menit == "0") ? "" : " $menit menit";
    $upDetik = ($sisaDetik == "0") ? "" : " $sisaDetik detik";

    $send = [
        'no' => $i++,
        'username' => $row['username'],
        'name' => $row['name'],
        'division' => $row['division'],
        'ip' => $row["framedipaddress"],
        'mac' => $row["callingstationid"],
        'startTime' => $row["acctstarttime"],
        'upTime' => $upJam . $upMenit . $upDetik
    ];

    array_push($data, $send);
}

echo json_encode($data);
