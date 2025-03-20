<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
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
            <h3>About</h3>
            <p><a href="index.php"><i class="bi bi-house-fill"> | Go Home</i></a></p>
        </div>
    </section>

    <section class="container-fluid aboutContent">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                  <img src="assets/images/family.jpg" alt="" class="aboutImg">
                </div>
                <div class="col-md-6 aboutText">
                  <h3 class="aboutHeader">About Us</h3>
                      <p>Parents Connect is a hub for parents to access reliable information on the best childcare practices to help them cater for the children and to provide the support they need in their parenting journey.</p>
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
</body>
</html>