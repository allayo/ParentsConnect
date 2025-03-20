<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parents_connect";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information from database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $firstname = $row['firstName'];
    $lastname = $row['lastName'];
    $username = $row['username'];
    $email = $row['email'];

    // Initialize update message variable
    $update_message = '';

    // Handle form submission for updating user info
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newFirstname = $_POST['firstname'];
        $newLastname = $_POST['lastname'];
        $newUsername = $_POST['username'];
        $newEmail = $_POST['email'];

        // Check if there are actual changes
        if ($newFirstname != $firstname || $newLastname != $lastname || $newUsername != $username || $newEmail != $email) {
            // Update user information in database
            $update_sql = "UPDATE users SET firstName=?, lastName=?, username=?, email=? WHERE username=?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sssss", $newFirstname, $newLastname, $newUsername, $newEmail, $_SESSION['username']);

            if ($stmt->execute()) {
                $update_message = "Update successful!";
                // Update session with new username if it was changed
                $_SESSION['username'] = $newUsername;

                // Update displayed information
                $firstname = $newFirstname;
                $lastname = $newLastname;
                $username = $newUsername;
                $email = $newEmail;

                // Log the update
                log_update($conn, "User updated information: $username");
            } else {
                $update_message = "Error updating record: " . $conn->error;
            }
        } else {
            $update_message = "No changes made.";
        }
    }
} else {
    echo "User not found.";
    exit;
}

$conn->close();

// Function to log updates
function log_update($conn, $update_text) {
    $sql_insert_update = "INSERT INTO updates (update_text) VALUES (?)";
    $stmt = $conn->prepare($sql_insert_update);
    $stmt->bind_param("s", $update_text);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.js"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
</head>
<body>

<main class="container-fluid" id="profileContain">
    <div class="container profileBody">
        <header class="profileHeader">
            <h3><a class="backHome" href="index.php"><i class="bi bi-arrow-left"></i></a></h3>
        </header>
        <h2 class="welcomeProfile">Welcome, <?php echo htmlspecialchars($username); ?></h2>

        <!-- Display update message -->
        <?php if (!empty($update_message)) : ?>
            <div class="update-message"><?php echo $update_message; ?></div>
        <?php endif; ?>

        <div class="user-info">
            <p class="userInfo">Your Information</p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group profileInput">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" class="contactrounded-input" value="<?php echo htmlspecialchars($firstname); ?>" required>
                </div>
                <div class="form-group profileInput">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" class="contactrounded-input" value="<?php echo htmlspecialchars($lastname); ?>" required>
                </div>
                <div class="form-group profileInput">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="contactrounded-input" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group profileInput">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="contactrounded-input" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <button class="registerBtn" type="submit">Update</button>
            </form>
        </div>

        <section class="logout">
            <a href="logout.php">Logout</a>
        </section>
    </div>
</main>

<script>
    $(document).ready(function() {
        if ($(".update-message").length) {
            setTimeout(function() {
                $(".update-message").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 2000);
        }
    });
</script>
</body>
</html>