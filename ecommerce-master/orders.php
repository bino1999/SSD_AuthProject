<?php
//prevent Application Error Disclosure
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to index.php if user is not logged in
if (!isset($_SESSION["username"])) {
    header("location:index.php");
    exit(); // Stop further execution to prevent disclosing sensitive information
}

// Include configuration file
include 'config.php';
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Orders || BOLT Sports Shop</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <li class="name">
                <h1><a href="index.php">BOLT Sports Shop</a></h1>
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
        </ul>

        <section class="top-bar-section">
            <!-- Right Nav Section -->
            <ul class="right">
                <li><a href="about.php">About</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">View Cart</a></li>
                <li class="active"><a href="orders.php">My Orders</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                // Display navigation links based on user login status
                if (isset($_SESSION['username'])) {
                    echo '<li><a href="account.php">My Account</a></li>';
                    echo '<li><a href="logout.php">Log Out</a></li>';
                } else {
                    echo '<li><a href="login.php">Log In</a></li>';
                    echo '<li><a href="register.php">Register</a></li>';
                }
                ?>
            </ul>
        </section>
    </nav>

    <div class="row" style="margin-top:10px;">
        <div class="large-12">
            <h3>My COD Orders</h3>
            <hr>

            <?php
            try {
                $user = $_SESSION["username"];
                $result = $mysqli->query("SELECT * from orders where email='" . $user . "'");
                if ($result) {
                    while ($obj = $result->fetch_object()) {
                       
                        echo '<p><h4>Order ID ->' . $obj->id . '</h4></p>';
                        echo '<p><strong>Date of Purchase</strong>: ' . $obj->date . '</p>';
                        echo '<p><strong>Product Code</strong>: ' . $obj->product_code . '</p>';
                        echo '<p><strong>Product Name</strong>: ' . $obj->product_name . '</p>';
                        echo '<p><strong>Price Per Unit</strong>: ' . $obj->price . '</p>';
                        echo '<p><strong>Units Bought</strong>: ' . $obj->units . '</p>';
                        echo '<p><strong>Total Cost</strong>: ' . $currency . $obj->total . '</p>';
                        echo '<p><hr></p>';
                    }
                }
            } catch (Exception $e) {
                // the server side
                error_log("Error in orders.php: " . $e->getMessage());

                // the user
                echo '<p>Sorry, there was an error processing your request. Please try again later.</p>';
            }
            ?>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <div class="small-12">
            <footer style="margin-top:10px;">
                <p style="text-align:center; font-size:0.8em;">&copy; BOLT Sports Shop. All Rights Reserved.</p>
            </footer>
        </div>
    </div>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>

</html>
