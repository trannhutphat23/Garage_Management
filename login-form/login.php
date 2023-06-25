<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginn.css">
    <link rel="stylesheet" href="fontawesome-free-6.3.0-web/fontawsome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;300;400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.google.com/specimen/IBM+Plex+Sans?query=bold&subset=vietnamese&noto.script=Latn">
    <title>CNPM</title>
</head>
<body>
    <div class="wrapper">
        <form class="login-form" method="POST" action="check_login.php">
            <div class="log-title">
                <h2 style="font-size: 30px; color: white;">ĐĂNG NHẬP</h2>
            </div>
            <div class="log">
                <i class="fa-solid fa-user"></i>
                <input id="account" type="text" name="User" placeholder="Tên đăng nhập">
            </div>
            <div class="log">
                <i class="fa-solid fa-lock"></i>
                <input id="password" type="password" name="Password" placeholder="Mật khẩu">
            </div>
            <input id="log-btn" class="btn" type="submit" value="ĐĂNG NHẬP" name="log-submit">
        </form>
    </div>
    <script src="login.js"></script>
</body>
</html>