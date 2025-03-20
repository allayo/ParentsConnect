<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parents_connect";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$register_message = '';
$message_type = '';

// Function to log updates
function log_update($conn, $update_text) {
    $sql_insert_update = "INSERT INTO updates (update_text) VALUES (?)";
    $stmt = $conn->prepare($sql_insert_update);
    $stmt->bind_param("s", $update_text);
    $stmt->execute();
}

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $email = $_POST['email'];

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert user data into database
        $sql = "INSERT INTO users (firstName, lastName, username, password, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstname, $lastname, $username, $password, $email);

        if ($stmt->execute()) {
            // Log the registration
            log_update($conn, "New user registered: $username");

            $register_message = "Registration successful!";
            $message_type = 'success';
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'login.php';
                    }, 3000); // Redirect after 3 seconds
                  </script>";
        } else {
            $register_message = "Error: " . $stmt->error;
            $message_type = 'error';
        }
    } else {
        $register_message = "Registration failed: Username already exists.";
        $message_type = 'error';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parents Connect</title>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.js"></script>
</head>
<body>
<main class="registerPage">
    <div class="logoContainer">
        <div class="companyLogo">
            <a href="login.php">Parents Connect</a>
        </div>
    </div>

    <div class="container registrationBody">
        <?php if (!empty($register_message)) : ?>
            <div id="message" class="<?php echo $message_type == 'success' ? 'success-message' : 'error-message'; ?>">
                <?php echo $register_message; ?>
            </div>
        <?php endif; ?>
        <div class="registerContent">
            <div class="registerFormText">
                <h4>Welcome</h4>
                <p>Already have an account?</p>
                <a href="login.php" class="loginPageBtn">Sign In</a>
            </div>
            <div class="registerForm">
                <h3>Create an Account</h3>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="formRow">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="regFormInput" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" class="regFormInput" required>
                        </div>
                    </div>
                    <div class="formRow">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="regFormInput" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="regFormInput" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="regFormInput" required>
                    </div>
                    <button type="submit" class="registerBtn">Register</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        if ($("#message").length) {
            setTimeout(function() {
                $("#message").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 3000);
        }
    });
</script>
</body>
</html>