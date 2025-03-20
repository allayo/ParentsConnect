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

// Handle form submission for adding meals
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addMeal'])) {
    $mealName = $_POST['mealName'];
    $breakfast = $_POST['breakfast'];
    $snack = $_POST['snack'];
    $lunch = $_POST['lunch'];
    $dinner = $_POST['dinner'];

    $sql = "INSERT INTO meals (mealName, breakfast, snack, lunch, dinner) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $mealName, $breakfast, $snack, $lunch, $dinner);

    if ($stmt->execute()) {
        header("Location: addMeal.php?success=1");
        exit();
    } else {
        echo "<script>alert('Error adding meal');</script>";
    }
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteMeal'])) {
    $mealId = $_POST['mealId'];

    $sql = "DELETE FROM meals WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mealId);

    if ($stmt->execute()) {
        header("Location: addMeal.php?deleted=1");
        exit();
    } else {
        echo "<script>alert('Error deleting meal');</script>";
    }
}

// Fetch meals from database
$sql = "SELECT * FROM meals";
$result = $conn->query($sql);
$meals = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meals[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meal - Admin</title>
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
        <h2 class="dashboardHeader">Parents Connect - Add Meal</h2>
        
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success">
                <p>Meal added successfully</p>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="alert alert-success">
                <p>Meal deleted successfully</p>
            </div>
        <?php endif; ?>
        
        <div class="container mealsTableCont">
            <div class="table-responsive-sm">
                <table class="table table-bordered">
                    <thead class="tableHeadColor">
                    <tr>
                        <th>ID</th>
                        <th>Meal Name</th>
                        <th>Breakfast</th>
                        <th>Snack</th>
                        <th>Lunch</th>
                        <th>Dinner</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($meals) > 0): ?>
                        <?php foreach ($meals as $meal): ?>
                            <tr>
                                <td><?php echo $meal['id']; ?></td>
                                <td><?php echo $meal['mealName']; ?></td>
                                <td><?php echo $meal['breakfast']; ?></td>
                                <td><?php echo $meal['snack']; ?></td>
                                <td><?php echo $meal['lunch']; ?></td>
                                <td><?php echo $meal['dinner']; ?></td>
                                <td>
                                    <form method="post" action="addMeal.php" style="display:inline;">
                                        <input type="hidden" name="mealId" value="<?php echo $meal['id']; ?>">
                                        <button type="submit" name="deleteMeal" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No meals found</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container mealContainer">
            <h4 class="mealContTitle">Add Meal</h4>
            <div class="mealForm">
                <form method="post" action="addMeal.php">
                    <div class="form-group">
                        <label for="mealName">Meal Name</label>
                        <input type="text" id="mealName" name="mealName" class="contactrounded-input" required>
                    </div>
                    <div class="form-group">
                        <label for="breakfast">Breakfast</label>
                        <input type="text" id="breakfast" name="breakfast" class="contactrounded-input" required>
                    </div>
                    <div class="form-group">
                        <label for="snack">Snack</label>
                        <input type="text" id="snack" name="snack" class="contactrounded-input" required>
                    </div>
                    <div class="form-group">
                        <label for="lunch">Lunch</label>
                        <input type="text" id="lunch" name="lunch" class="contactrounded-input" required>
                    </div>
                    <div class="form-group">
                        <label for="dinner">Dinner</label>
                        <input type="text" id="dinner" name="dinner" class="contactrounded-input" required>
                    </div>
                    <button type="submit" name="addMeal" class="mealBtn">Add Meal</button>
                </form>
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
<script>
    $(document).ready(function(){
        setTimeout(function(){
            $(".alert-success").fadeOut('slow');
        }, 5000);
    });
</script>
</body>
</html>