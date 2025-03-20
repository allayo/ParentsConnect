<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "parents_connect";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";

// Function to log updates
function log_update($conn, $update_text) {
    $sql_insert_update = "INSERT INTO updates (update_text) VALUES (?)";
    $stmt = $conn->prepare($sql_insert_update);
    $stmt->bind_param("s", $update_text);
    $stmt->execute();
}

// Handle new post submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && isset($_POST['writeup'])) {
    $title = $_POST['title'];
    $writeup = $_POST['writeup'];
    $author = $username;
    $postDate = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO community (author, post_date, title, writeup) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $author, $postDate, $title, $writeup);

    if ($stmt->execute()) {
        // Log the action
        log_update($conn, "User $username shared a post titled '$title'");
        
        // Redirect to the same page to prevent form resubmission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit; 
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle like button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['like_post_id'])) {
    $postId = $_POST['like_post_id'];

    // Check if the user has already liked this post
    $likeCheckQuery = "SELECT * FROM likes WHERE post_id = ? AND username = ?";
    $stmt = $conn->prepare($likeCheckQuery);
    $stmt->bind_param("is", $postId, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Add like
        $stmt = $conn->prepare("INSERT INTO likes (post_id, username) VALUES (?, ?)");
        $stmt->bind_param("is", $postId, $username);
        if ($stmt->execute()) {
            // Increment like count
            $stmt = $conn->prepare("UPDATE community SET like_count = like_count + 1 WHERE id = ?");
            $stmt->bind_param("i", $postId);
            $stmt->execute();

            // Log the action
            log_update($conn, "User $username liked a post with ID $postId");
        }
    }
    $stmt->close();
}

// Handle delete post button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_post_id'])) {
    $postId = $_POST['delete_post_id'];

    // Check if the post belongs to the current user
    $checkPostQuery = "SELECT * FROM community WHERE id = ? AND author = ?";
    $stmt = $conn->prepare($checkPostQuery);
    $stmt->bind_param("is", $postId, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete the post
        $deleteQuery = "DELETE FROM community WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $successMessage = "Post deleted successfully";

            // Log the action
            log_update($conn, "User $username deleted a post with ID $postId");
        } else {
            echo "Error deleting post: " . $stmt->error;
        }
    } else {
        echo "You do not have permission to delete this post.";
    }

    $stmt->close();
}

// Fetch all posts from database
$posts = [];
$sql = "SELECT * FROM community ORDER BY post_date DESC";
$result = $conn->query($sql);
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
    <title>Parents Connect</title>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.js"></script>
    <script>
        // JavaScript function to remove success message after 3 seconds
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000); 
    </script>
</head>
<body>

<header>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn"> 
            <i class="fa fa-bars"></i>
        </label>
        <label class="logo">Parents Connect</label>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li class="dropdown-parent">
                <a href="#">Resources</a>
                <ul class="dropdown">
                    <li><a href="blogs.php">Blogs</a></li>
                    <li><a href="planner.php">Planner</a></li>
                    <li><a href="community.php">Community</a></li>
                </ul>
            </li>
            <li><a href="contact.php">Contact</a></li>
            <li><a class="regLog" href="profile.php">Profile</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="container-fluid informContent">
        <div class="informHeader">
            <h3>Community</h3>
            <p><a href="index.php"><i class="bi bi-house-fill"> | Go Home</i></a></p>
        </div>
    </section>

    <section class="container-fluid aboutContent">
        <div class="container">
            <div class="row">
                <div class="col-md-12 aboutText">
                    <h2 class="welcomeProfile">Welcome to the community, <?php echo htmlspecialchars($username); ?></h2>
                    <p>Explore, share your own experiences and join the conversation</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 communityItem">
                    <h4>General Discussions</h4>
                    <p>Share stories, advice, pictures and more!</p>
                    <span class="readBtn">20 Views</span>
                    <span class="shareBtn">5 Posts <i class="bi bi-send-fill"></i></span>
                    <span class="followBtn">Following <i class="bi bi-check-circle-fill"></i></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 communityItem">
                    <h4>Infant Care</h4>
                    <p>Join the conversation, see what others are saying...</p>
                    <span class="readBtn">210 Views</span>
                    <span class="shareBtn">2 Posts <i class="bi bi-send-fill"></i></span>
                    <span class="followBtn">Following <i class="bi bi-check-circle-fill"></i></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 communityItem">
                    <h4>Early morning routine plan (For Teens)</h4>
                    <p>Learn how to help your teens prepare for their day quickly and effectively.</p>
                    <span class="readBtn">1000 Views</span>
                    <span class="shareBtn">12 Posts <i class="bi bi-send-fill"></i></span>
                    <span class="followBtn">Following <i class="bi bi-check-circle-fill"></i></span>
                </div>
            </div>
            <div class="comPost">
                <h4>New Posts</h4>
                <?php if ($successMessage): ?>
                        <p id="successMessage" class="successMessage"><?php echo htmlspecialchars($successMessage); ?></p>
                    <?php endif; ?>
                <div class="row" id="postsContainer">
                    <?php foreach ($posts as $post): ?>
                        <div class="col-md-4 communityItem">
                            <p class="postAuthor">Author: <?php echo htmlspecialchars($post['author']); ?></p>
                            <p class="postDate">Date: <?php echo htmlspecialchars($post['post_date']); ?></p>
                            <h4 class="commTitle"><?php echo htmlspecialchars($post['title']); ?></h4>
                            <p class="commSub"><?php echo htmlspecialchars($post['writeup']); ?></p>
                            <!-- Delete button form -->
                            <?php if ($post['author'] === $username): ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="delete_post_id" value="<?php echo $post['id']; ?>">
                                    <button type="submit" class="deleteBtn">Delete Post</button>
                                </form>
                            <?php endif; ?>

                            <!-- Like button form -->
                            <form method="POST" action="">
                                <input type="hidden" name="like_post_id" value="<?php echo $post['id']; ?>">
                                <button type="submit" class="likeBtn"><?php echo htmlspecialchars($post['like_count']); ?> <i class="bi bi-heart"></i></button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 communityForm">
                    <h4>Create a Post</h4>
                    <p>Share your thoughts with others</p>
                    
                    <form method="POST" action="">
                        <div class="formRow">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="regFormInput" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="writeup">Writeup</label>
                            <textarea type="text" id="writeup" name="writeup" class="regFormInput" required></textarea>
                        </div>
                        <button type="submit" class="loginBtn">Share Post</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

<footer>
    <section class="footer container-fluid">
        <div class="container">
            <div class="row socialLinks justify-content-center">
                <div class="col-md-12">
                    <ul>
                        <li><a href="#"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                        <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row pagesLinks justify-content-center">
                <div class="col-md-12">
                    <a href="index.php">| Home |</a>
                    <a href="about.php">| About |</a>
                    <a href="contact.php">| Contact |</a>
                </div>
            </div>
            <div class="row copyRight justify-content-center">
                <div class="col-md-12">
                    <p>&copy; 2024 Parents Connect Ltd. All rights reserved.</p>
                </div>
            </div>
        </div>
    </section>
</footer>

<script src="assets/js/addlike.js"></script>
</body>
</html>