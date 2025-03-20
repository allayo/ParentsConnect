<?php
// Initialize the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Display the success message and then redirect to login.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Successful</title>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
    <script>
        // Redirect to login page after 3 seconds
        setTimeout(function() {
            window.location.href = "login.php";
        }, 3000);
    </script>
</head>
<body>
    <main class="logoutMessage">
        <div class="container logoutText">
            <h1>Logout successful!</h1>
            <p><i class="bi bi-check-circle-fill"></i></p>
        </div>
    </main>
</body>
</html>