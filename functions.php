<?php
include 'dbconn.php';

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    if (!$result) {
        return $rows;
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;
    $username = htmlspecialchars($data["username"]);
    $name = htmlspecialchars($data["name"]);
    $division = htmlspecialchars($data["division"]);
    $class = htmlspecialchars($data["class"]);
    $date = date('Y-m-d', time());
    $password = htmlspecialchars($data["password"]);

    $result = mysqli_query($conn, "SELECT username FROM radcheck WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('username sudah ada')</script>";
        return false;
    }
    $query = "INSERT INTO radcheck VALUE (NULL, '$username', 'Cleartext-Password', ':=', '$password')";
    mysqli_query($conn, $query);

    $query2 = "INSERT INTO organization VALUE (NULL, '$username', '$name', '$division', '$class', '$date')";
    mysqli_query($conn, $query2);

    return mysqli_affected_rows($conn);
}

function delete($id)
{
    global $conn;
    $username = query("SELECT username FROM radcheck WHERE id = '$id'");
    $username = $username[0]['username'];

    mysqli_query($conn, "DELETE FROM radcheck WHERE id = '$id'");
    mysqli_query($conn, "DELETE FROM organization WHERE username = '$username'");
    return mysqli_affected_rows($conn);
}

function edit($data)
{
    global $conn;
    $id = $data["id"];
    $userRadcheck = query("SELECT * FROM radcheck WHERE id = '$id'")[0];
    $usernameOld = $userRadcheck['username'];
    $userOrganization = query("SELECT * FROM organization WHERE username = '$usernameOld'")[0];
    $iduserOrg = $userOrganization['id'];

    $username = htmlspecialchars($data["username"]);
    $name = htmlspecialchars($data["name"]);
    $division = htmlspecialchars($data["division"]);
    $class = htmlspecialchars($data["class"]);
    $password = htmlspecialchars($data["password"]);

    $query = "UPDATE radcheck SET username = '$username', value = '$password', attribute = 'Cleartext-Password', op = ':=' WHERE id = $id";

    $query2 = "UPDATE organization SET username = '$username', name = '$name', division = '$division', class = '$class' WHERE id = '$iduserOrg'";

    mysqli_query($conn, $query);
    mysqli_query($conn, $query2);

    return mysqli_affected_rows($conn);
}

function changepassword($data)
{
    global $conn;

    $id = $data["id"];

    $username = htmlspecialchars($data["username"]);

    $oldpassword = htmlspecialchars($data["oldpassword"]);
    $newpassword = htmlspecialchars($data["newpassword"]);
    $newpassword2 = htmlspecialchars($data["newpassword2"]);

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE id = '$id'");

    $admin = mysqli_fetch_assoc($result);

    if (!password_verify($oldpassword, $admin["password"])) {
        echo "<script>alert('password lama tidak sesuai')</script>";
        return false;
    }

    if ($newpassword !== $newpassword2) {
        echo "<script>alert('Password tidak sama')</script>";
        return false;
    }

    $newpasswordEncrypth = password_hash($newpassword, PASSWORD_DEFAULT);

    mysqli_query($conn, "UPDATE admin SET username = '$username', password = '$newpasswordEncrypth' WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function appsVar()
{
    $data = [
        'appsVers' => '1.52',
        'dbVers' => '1.1'
    ];
    return $data;
}
