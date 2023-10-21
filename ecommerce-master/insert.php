<?php
// sql injection prevent
// Parameter Tampering prevent
// Set the Content Security Policy header to mitigate security risks 
include 'config.php';
  
header("Content-Security-Policy: default-src 'self'; script-sre 'self' https://ajax.googleapis.com; style-src 'self' https://maxcdn.bootstrapcdn.com; img-src 'self' data:; font-src 'self'; frame-ancestors 'self';");

// Function to sanitize and validate input
function sanitizeInput($input)
{
    // Use appropriate validation
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}


// Get and sanitize user inputs
$fname = sanitizeInput($_POST["fname"]);
$lname = sanitizeInput($_POST["lname"]);
$address = sanitizeInput($_POST["address"]);
$city = sanitizeInput($_POST["city"]);
$pin = sanitizeInput($_POST["pin"]);
$email = sanitizeInput($_POST["email"]);
$pwd = sanitizeInput($_POST["pwd"]);

// Use prepared 
$stmt = $mysqli->prepare("INSERT INTO users (fname, lname, address, city, pin, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Bind parameters 
$stmt->bind_param("ssssiss", $fname, $lname, $address, $city, $pin, $email, $pwd);

// Execute the statement
if ($stmt->execute()) {
    // Data inserted successfully
    echo 'Data inserted';
    echo '<br/>';
} else {
       //to server
    error_log('Error inserting data: ' . $stmt->error);

    //  to the user
    echo 'An error occurred while processing your request. Please try again later.';
    echo '<br/>';
}

// Close the statement
$stmt->close();

// Redirect to login page
header("location: login.php");
?>
