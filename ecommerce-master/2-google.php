<?php
// (A) LOAD GOOGLE CLIENT LIBRARY
require("vendor/autoload.php");

// (B) NEW GOOGLE CLIENT
$goo = new Google\Client();
$goo->setClientId("627404349415-u6ig6vmjpchnlgveuqoisgfs9tv43qef.apps.googleusercontent.com");
$goo->setClientSecret("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");
$goo->addScope("email");
$goo->addScope("profile");
$goo->setRedirectUri("http://localhost/ecommerce-master/3-login.php");