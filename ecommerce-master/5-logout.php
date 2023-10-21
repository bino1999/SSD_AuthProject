<?php
// (A) NOT LOGGED IN
session_start();
if (!isset($_SESSION["token"])) {
  header("Location: 3-login.php"); exit;
}

// (B) REMOVE & REVOKE TOKEN
require "2-google.php";
$goo->setAccessToken($_SESSION["token"]);
$goo->revokeToken();
unset($_SESSION["token"]);
// REMOVE YOUR OWN USER SESSION VARIABLES AS WELL
header("Location: 3-login.php"); exit;