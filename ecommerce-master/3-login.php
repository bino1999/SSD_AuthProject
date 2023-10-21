<?php

//prevent Missing Anti-clickjacking Header

// (A) ALREADY SIGNED IN
session_start();
if (isset($_SESSION["token"])) {
    header("Location: 4-home.php");
    exit;
}

// (B) ON LOGIN - PUT TOKEN INTO SESSION
require "2-google.php";
if (isset($_GET["code"])) {
    $token = $goo->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (!isset($token["error"])) {
        $_SESSION["token"] = $token;
        header("Location: 4-home.php");
        exit;
    }
}

// (C) SHOW LOGIN PAGE
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login With Google</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 50px;
        }

        h1 {
            color: #333;
        }

        a {
            display: inline-block;
            padding: 15px 30px;
            background-color: #4285f4;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .error {
            color: #ff0000;
            margin-top: 10px;
        }
    </style>

 <!-- X-Frame-Options headers -->
    <meta http-equiv="X-Frame-Options" content="DENY">

</head>

<body>
    <?php if (isset($token["error"])) { ?>
        <div class="error"><?= print_r($token); ?></div>
    <?php } ?>

    <h1>Login With Google</h1>
    <a href="<?= $goo->createAuthUrl() ?>" class="btn-google-login">Login with Google</a>
</body>

</html>
