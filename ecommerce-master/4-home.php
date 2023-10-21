<?php
// (A) NOT LOGGED IN
session_start();
if (!isset($_SESSION["token"])) {
  header("Location: 3-login.php"); exit;
}

// (B) TOKEN EXPIRED - TO LOGIN PAGE
require "2-google.php";
$goo->setAccessToken($_SESSION["token"]);
if ($goo->isAccessTokenExpired()) {
  unset($_SESSION["token"]);
  header("Location: 3-login.php"); exit;
}

// (C) GET USER PROFILE
$user = (new Google\Service\Oauth2($goo))->userinfo->get();

// (D) DISPLAY USER DETAILS
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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

        p {
            color: #555;
        }

        .user-info {
            display: inline-block;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .user-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info span {
            display: block;
            margin-top: 10px;
        }

        .logout {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4285f4;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>User Profile</h1>
    <div class="user-info">
        <img src="'.$user['picture'].'" alt="'.$user['name'].'">
        <span>Name: '.$user['name'].'</span>
        <span>Email: '.$user['email'].'</span>
        <span>Gender: '.$user['gender'].'</span>
        <span>Locale: '.$user['locale'].'</span>
    </div>
    <a class="logout" href="logout.php">Logout</a> <!-- Add this link -->
</body>

</html>';
?>
