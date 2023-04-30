<?php
if ($_SERVER["REQUEST_METHOD"] != 'POST') {
    die('Akses ditolak!');
}

header('Content-Type: application/json; charset=utf-8');

require "../functions.php";
global $conn;

$user = query("SELECT radcheck.id AS radcheck_id, 
        radcheck.value AS value, 
        radcheck.username AS radcheck_username, 
        organization.username AS org_username, 
        organization.name AS name, 
        organization.division AS division, 
        organization.registered_at as registered_at 
        FROM radcheck 
        LEFT JOIN organization ON radcheck.username = organization.username
        ORDER BY registered_at DESC
    ");

$data = [];
$i = 1;
foreach ($user as $row) {
    $temp = [
        'no' => $i++,
        'username' => '<code>' . $row['radcheck_username'] . '</code>',
        'name' => $row['name'],
        'division' => $row['division'],
        'regdate' => $row['registered_at'],
        'password' => '
            <input type="password" readonly class="form-control-plaintext text-center" id="pass_' . $row['radcheck_id'] . '" value="' . $row['value'] . '">
        ',
        'action' => '
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-warning btn-sm" title="Tunjukan password user: ' . $row['radcheck_username'] . '?" onclick="showPassword(`pass_' . $row['radcheck_id'] . '`)"><i class="fas fa-key"></i></button>
                <button type="button" class="btn btn-warning btn-sm" title="Edit user: ' . $row['radcheck_username'] . '?" onclick="editUser(`' . $row['radcheck_id'] . '`)"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-sm" title="Delete user: ' . $row['radcheck_username'] . '?" onclick="deleteUser(`' . $row['radcheck_id'] . '`)"><i class="fas fa-trash-alt"></i></button>
            </div>
        '
    ];
    array_push($data, $temp);
}

print_r(json_encode($data));
