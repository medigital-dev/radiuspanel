<?php

session_start();

require 'functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM admin WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha384', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["passwords"];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            $_SESSION["login"] = true;

            if (isset($_POST['remember'])) {
                setcookie('id', $row['id'], time() + 1440);
                setcookie('key', hash('sha384', $row['username']), time() + 1440);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

$jumlahAdmin = count(query("SELECT * FROM admin"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RadiusPanel - Login</title>
    <link rel="shortcut icon" href="img/icon_RadiusPanel-white.png" type="image/x-icon">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/default.css">
    <style>
        body {
            background-color: #F7F4F3;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <div style="width: 300px; height: 300px; background-color: #fff; border: 3px solid darkblue; border-radius: 10px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); line-height: 1.2;">
            <div align="center">
                <div style="width: 100%; margin-top: 2px; margin-bottom: 2px;">
                    <img src="img/RadiusPanel.png" width="95%">
                </div>
                <div style="background-color: darkblue; color: white; text-align: center; width: 95%; padding: 3px; font-weight: bold; margin: 5px 0 10px 0; border-radius: 10px">
                    LOGIN TO RADIUSPANEL
                </div>
                <div style="width: 80%; margin-bottom: 15px">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1" style="width: 40px; text-indent: 1px"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="username" id="username" autofocus>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="password" style="width: 40px"><i class="fa fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password" name="passwords" id="passwords">
                    </div>
                </div>
                <div style="display: flex;" class="mb-0">
                    <div class="form-group form-check" style="width: 45%">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Remember</label>
                    </div>
                    <div class="form-group form-check" style="width: 55%">
                        <input type="checkbox" class="form-check-input" id="showpass" onclick="ShowPassword()">
                        <label class="form-check-label" for="showpass">Show Password</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 95%" name="login">Enter</button>
            </div>
            <br>
            <center>
                <?php if (isset($error)) : ?>
                    <p style="color: red; font-size: 14px">Username / Password salah</p>
                <?php endif; ?>
                <?php if (!$conn) : ?>
                    <p style="color: red; font-weight: bold" colspan="3">Koneksi Database ERROR.<br>Cek db_koneksi.php</p-lg-3>
                    <?php endif; ?>
            </center>
            <div class="small text-muted text-center">
                &copy; 2023 Dibuat dan dikembangkan oleh <a href="https://muhsaidlg.my.id" target="blank">Muhammad Said Latif Ghofari</a> - v1.1
            </div>
        </div>
    </form>

    <script>
        function ShowPassword() {
            var x = document.getElementById("passwords");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    <!-- Optional JavaScript -->
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>