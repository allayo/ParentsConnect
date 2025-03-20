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

// Handle delete post
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM community WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>window.location.href='postsTable.php';</script>";
    } else {
        echo "<script>alert('Error deleting post');</script>";
    }
}

// Fetch posts from database
$sql = "SELECT * FROM community";
$result = $conn->query($sql);
$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Table - Admin</title>
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.js"></script>
    <style>
    </style>
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
        <h2 class="dashboardHeader">Parents Connect - Posts Table</h2>
        <div id="postConfirmationCont" class="postConfirmationCont " style="display: none;">
            <div class="confirmText">
                <p>Are you sure you want to delete this post?</p>
                <span><a href="#" id="confirmYes">Yes</a></span> 
                <span><a href="#" id="confirmNo">No</a></span>
            </div>
        </div>
        <div class="container postsTableCont">
            <div class="table-responsive-sm">
                <table class="table table-bordered">
                    <thead class="tableHeadColor">
                    <tr>
                        <th>ID</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Writeup</th>
                        <th>Likes</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($posts) > 0): ?>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['id']; ?></td>
                                <td><?php echo $post['author']; ?></td>
                                <td><?php echo $post['post_date']; ?></td>
                                <td><?php echo $post['title']; ?></td>
                                <td><?php echo $post['writeup']; ?></td>
                                <td><?php echo $post['like_count']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger deletePostBtn" data-id="<?php echo $post['id']; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No posts found</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
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
$(document).ready(function() {
    $('.deletePostBtn').on('click', function() {
        var postId = $(this).data('id');
        $('#confirmYes').attr('href', 'postsTable.php?delete=' + postId);
        $('#postConfirmationCont').fadeIn();
    });

    $('#confirmNo').on('click', function() {
        $('#postConfirmationCont').fadeOut();
    });
});
</script>
</body>
</html>