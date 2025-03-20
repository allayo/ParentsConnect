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

// Fetch data from the users table
$sql = "SELECT id, firstName, lastName, username, email FROM users";
$result = $conn->query($sql);

// Handle delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully');</script>";
        echo "<script>window.location.href='usersTable.php';</script>";
    } else {
        echo "<script>alert('Error deleting user');</script>";
    }
}

// Handle edit user
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $update_sql = "UPDATE users SET firstName = ?, lastName = ?, username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssi", $firstName, $lastName, $username, $email, $id);
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully');</script>";
        echo "<script>window.location.href='usersTable.php';</script>";
    } else {
        echo "<script>alert('Error updating user');</script>";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table - Admin</title>
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
        <h2 class="dashboardHeader">Parents Connect - Users Table</h2>
        <div id="confirmationCont" class="confirmationCont" style="display:none;">
            <div class="confirmText">
            <p>Are you sure you want to <span id="actionType"></span> this user?</p>
            <span><a href="#" id="confirmYes">Yes</a></span> <span><a href="#" id="confirmNo">No</a></span>
            </div>
        </div>
        <div class="container usersTableCont">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="tableHeadColor">
                        <tr>
                            <th>#</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Re-establish the database connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["firstName"] . "</td>";
                                echo "<td>" . $row["lastName"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>
                                    <button class='btn btn-primary userChangeBtn' onclick='showEditForm(" . json_encode($row) . ")'>Edit</button>
                                    <button class='btn btn-danger userChangeBtn' onclick='confirmAction(\"delete\", " . $row["id"] . ")'>Delete</button>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No users found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="editForm" class="editForm" style="display:none;">
            <h3>Edit User</h3>
            <form action="usersTable.php" method="post">
                <input type="hidden" name="id" id="editId">
                <div class="form-group">
                    <label for="editFirstName">First Name:</label>
                    <input type="text" class="form-control" name="firstName" id="editFirstName">
                </div>
                <div class="form-group">
                    <label for="editLastName">Last Name:</label>
                    <input type="text" class="form-control" name="lastName" id="editLastName">
                </div>
                <div class="form-group">
                    <label for="editUsername">Username:</label>
                    <input type="text" class="form-control" name="username" id="editUsername">
                </div>
                <div class="form-group">
                    <label for="editEmail">Email:</label>
                    <input type="email" class="form-control" name="email" id="editEmail">
                </div>
                <button type="submit" name="edit" class="btn btn-success">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="hideEditForm()">Cancel</button>
            </form>
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
function confirmAction(action, id) {
    document.getElementById('confirmationCont').style.display = 'block';
    document.getElementById('actionType').innerText = action;
    document.getElementById('confirmYes').href = action === 'delete' ? 'usersTable.php?delete=' + id : '#';
    document.getElementById('confirmYes').onclick = function() {
        if (action === 'edit') {
            showEditForm(id);
        }
    };
}

function showEditForm(user) {
    document.getElementById('confirmationCont').style.display = 'none';
    document.getElementById('editForm').style.display = 'block';
    document.getElementById('editId').value = user.id;
    document.getElementById('editFirstName').value = user.firstName;
    document.getElementById('editLastName').value = user.lastName;
    document.getElementById('editUsername').value = user.username;
    document.getElementById('editEmail').value = user.email;
}

function hideEditForm() {
    document.getElementById('editForm').style.display = 'none';
    document.getElementById('confirmationCont').style.display = 'none';
}

document.getElementById('confirmNo').onclick = function() {
    document.getElementById('confirmationCont').style.display = 'none';
}
</script>
</body>
</html>