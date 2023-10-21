<?php
// SQL injection prevention
// Set the Content Security Policy header to mitigate security risks 
session_start();

// DATABASE CONNECTION
include "config.php";


header("Content-Security-Policy: default-src 'self'; script-sre 'self' https://ajax.googleapis.com; style-src 'self' https://maxcdn.bootstrapcdn.com; img-src 'self' data:; font-src 'self'; frame-ancestors 'self';");

// (C) CHECK IF USER IS ALREADY LOGGED IN
if (isset($_SESSION["username"])) {
  header("Location: index.php");
  exit;
}

// CHECK IF FORM IS SUBMITTED
if (isset($_POST["username"]) && isset($_POST["password"])) {
  // PREPARE SQL QUERY WITH PLACEHOLDERS
  $sql = "SELECT id, email, password, fname, type FROM users WHERE email = ? AND password = ? LIMIT 1";

  // CREATE AND EXECUTE PREPARED STATEMENT
  if ($stmt = mysqli_prepare($db, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $_POST["username"], $_POST["password"]);

    if (mysqli_stmt_execute($stmt)) {
      // Store result
      mysqli_stmt_store_result($stmt);

      if (mysqli_stmt_num_rows($stmt) == 1) {
        // Fetch result row as an associative array
        $row = mysqli_stmt_fetch($stmt, MYSQLI_ASSOC);

        $_SESSION["username"] = $row["email"];
        $_SESSION["type"] = $row["type"];
        $_SESSION["id"] = $row["id"];
        $_SESSION["fname"] = $row["fname"];

        header("Location: index.php");
        exit;
      } else {
        // Redirect to a custom error page for invalid login
        header("Location: error.php?code=invalid_login");
        exit;
      }
    } else {
      // Log the error on the server side 
      error_log("SQL execution error: " . mysqli_error($db));
      
      // Redirect to a generic error page
      header("Location: error.php?code=generic_error");
      exit;
    }

    mysqli_stmt_close($stmt);
  } else {
    // Log the error on the server side (don't display details to users)
    error_log("Prepare statement error: " . mysqli_error($db));

    // Redirect to a generic error page
    header("Location: error.php?code=generic_error");
    exit;
  }
}

mysqli_close($db);
?>
