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
            <h3>Blogs</h3>
            <p><a href="index.php"><i class="bi bi-house-fill"> | Go Home</i></a></p>
        </div>
    </section>

    <section class="container-fluid featuredContent">
    <div class="container featuredBody">
        <div class="featuredText">
            <h3 class="featuredHeader">Blog Posts</h3>
            <p class="featuredSub">Most popular blog posts</p>
            
        </div>
        <div class="row">
            <div class="col-md-8 featureItem">
                <h4>Helping your child navigate pre school</h4>
                <p>Pre school, one of the earliest stage of a childs academic journey is as importaant as all other stages and its necessary for parents to ensure thier children...</p>
                <a href="#" class="readBtn">Read</a>
                <a href="#" class="shareBtn">Share Post <i class="bi bi-send-fill"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 featureItem">
            <h4>Steps to guide your child towards academic excellence</h4>
            <p>Academic excellence is the desire of all parents for their children, but the process of attaining excellent performance in school can be quite tedious for children. Gere are steps to follow to support...</p>
                <a href="#" class="readBtn">Read</a>
                <a href="#" class="shareBtn">Share Post <i class="bi bi-send-fill"></i></a>

            </div>
        </div>
        <div class="section-line"> </div>
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