<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

header('Content-Type: application/json; charset=utf-8');

require "../functions.php";
global $conn;

$log = query("SELECT 
	radpostauth.username AS auth_username, 
	radpostauth.reply AS reply, 
	radpostauth.authdate AS authdate, 
	organization.username AS org_username, 
	organization.name AS name, 
	organization.division AS division,
	radacct.framedipaddress AS framedipaddress,
	radacct.callingstationid AS callingstationid
	FROM radpostauth 
	LEFT JOIN organization ON radpostauth.username = organization.username 
	LEFT JOIN radacct ON radpostauth.username = radacct.username
	ORDER BY authdate DESC");

$data = [];
$i = 1;
foreach ($user as $row) {
    $temp = [
        'no' => $i++,
        'username' => '<code>' . $row['auth_username'] . '</code>',
        'name' => $row['name'],
        'division' => $row['division'],
        'ip' => $row["framedipaddress"],
        'mac' => $row["callingstationid"],
        'reply' => $row["reply"],
        'authDate' => $row["authdate"],
    ];
    array_push($data, $temp);
}

echo json_encode($data);
