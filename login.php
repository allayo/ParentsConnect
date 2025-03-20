<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parents_connect";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_message = '';
$message_type = '';

// Check if logout was successful
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    $login_message = "Logout successful!";
    $message_type = 'success';
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if account is locked
    if (isset($_SESSION['lockout']) && time() < $_SESSION['lockout']) {
        $login_message = "Account is locked. Try again in 10 minutes.";
        $message_type = 'error';
    } else {
        // Retrieve user data from database
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Password is correct, reset login attempts
                $_SESSION['username'] = $username;
                $_SESSION['attempts'] = 0;
                $login_message = "Login successful!";
                $message_type = 'success';
                echo "<script>
                        setTimeout(function(){
                            window.location.href = 'index.php';
                        }, 1000); // Redirect after 1 second
                      </script>";
            } else {
                // Invalid password
                $login_message = "Invalid username or password.";
                $message_type = 'error';
                handle_login_attempts();
            }
        } else {
            // Username not found
            $login_message = "Username does not exist.";
            $message_type = 'error';
            handle_login_attempts();
        }
    }
}

$conn->close();

function handle_login_attempts() {
    global $login_message, $message_type;

    if (!isset($_SESSION['attempts'])) {
        $_SESSION['attempts'] = 1;
    } else {
        $_SESSION['attempts']++;
    }

    if ($_SESSION['attempts'] >= 3) {
        $_SESSION['lockout'] = time() + (10 * 60); // Lock for 10 minutes
        $login_message = "Too many failed attempts. Account locked for 10 minutes.";
        $message_type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parents Connect</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>

<main class="loginPage">
    <div class="logoContainer">
        <div class="companyLogo">
            <a href="login.php">Parents Connect</a>
        </div>
    </div>

    <div class="container loginBody">
        <?php if (!empty($login_message)) : ?>
            <div id="message" class="<?php echo $message_type == 'success' ? 'success-message' : 'error-message'; ?>">
                <?php echo $login_message; ?>
            </div>
        <?php endif; ?>
        <div class="loginContent">
            <div class="loginFormText">
                <h4>Hello there</h4>
                <p>Don't have an account?</p>
                <a href="register.php" class="regPageBtn">Register</a>
            </div>
            <div class="loginForm">
                <h3>Login</h3>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="formRow">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="regFormInput" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="regFormInput" required>
                    </div>
                    <button type="submit" class="loginBtn">Login</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        if ($("#message").length) {
            setTimeout(function() {
                window.location.href = "login.php";
            }, 3000);
        }
    });
</script>
</body>
</html>