<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
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

// Handle dismiss action
if (isset($_GET['dismiss'])) {
    $dismissId = $_GET['dismiss'];
    // Update the Action update to be dismissed
    $dismiss_sql = "UPDATE updates SET dismissed = 1 WHERE id = $dismissId";
    if ($conn->query($dismiss_sql) === TRUE) {
        // Redirect to avoid form resubmission on page refresh
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error dismissing update: " . $conn->error;
    }
}

// Fetch the number of users
$sql_users = "SELECT COUNT(*) as user_count FROM users";
$result_users = $conn->query($sql_users);
if (!$result_users) {
    die("Error executing query for users: " . $conn->error);
}
$user_count = $result_users->fetch_assoc()['user_count'];

// Fetch the number of posts
$sql_posts = "SELECT COUNT(*) as post_count FROM community";
$result_posts = $conn->query($sql_posts);
if (!$result_posts) {
    die("Error executing query for posts: " . $conn->error);
}
$post_count = $result_posts->fetch_assoc()['post_count'];

// Fetch the number of meals
$sql_meals = "SELECT COUNT(*) as meal_count FROM meals";
$result_meals = $conn->query($sql_meals);
if (!$result_meals) {
    die("Error executing query for meals: " . $conn->error);
}
$meal_count = $result_meals->fetch_assoc()['meal_count'];

// Fetch the latest updates that are not dismissed
$sql_updates = "SELECT id, update_text, created_at FROM updates WHERE dismissed = 0 ORDER BY created_at DESC LIMIT 5";
$result_updates = $conn->query($sql_updates);
if (!$result_updates) {
    die("Error executing query for updates: " . $conn->error);
}
$updates = $result_updates->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Parents Connect</title>
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.js"></script>
</head>
<body>

<main class="dashBoardPage">
<div class="sidebar">
  <a class="active" href="dashboard.php">Dashboard <i class="bi bi-house-fill"></i></a>
  <a href="usersTable.php">Users <i class="bi bi-people-fill"></i></a>
  <a href="postsTable.php">Posts <i class="bi bi-card-text"></i></a>
  <a href="addMeal.php">Add Meal Plan <i class="bi bi-list-ol"></i></a>
  <a href="logout.php">Logout <i class="bi bi-box-arrow-right"></i></a>
</div>

<div class="dashboardContent">
    <h2 class="dashboardHeader">Parents Connect - Admin Dashboard</h2>
    <div class="container dataBCount">
        <div class="row">
            <div class="col-md-3 dataBItem">
                <p class="dataBTitle">Users <i class="bi bi-people-fill"></i></p>
                <p class="dataBNumber"><?php echo $user_count; ?></p>
            </div>
            <div class="col-md-3 dataBItem">
                <p class="dataBTitle">Posts <i class="bi bi-card-text"></i></p>
                <p class="dataBNumber"><?php echo $post_count; ?></p>
            </div>
            <div class="col-md-3 dataBItem">
                <p class="dataBTitle">Meal Plan <i class="bi bi-list-ol"></i></p>
                <p class="dataBNumber"><?php echo $meal_count; ?></p>
            </div>
        </div>
        <div class="row">
            <h2 class="latestUpdatesTitle">Latest Updates</h2>
            <div class="latestUpdates">
                <?php foreach ($updates as $update): ?>
                    <div class="updateDetails">
                        <p><?php echo $update['update_text']; ?> (<?php echo $update['created_at']; ?>)</p>
                        <a href="dashboard.php?dismiss=<?php echo $update['id']; ?>" class="btn btn-danger btn-sm">Dismiss</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
</main>

<footer>
    <section class="footer container-fluid">
        <div class="container">
            <div class="row copyRight justify-content-center">
                <div class="col-md-12">
                    <p>&copy; 2024 Parents Connect Ltd. All rights reserved.</p>
                </div>
            </div>
        </div>
    </section>
</footer>
</body>
</html>